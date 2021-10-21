<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cornerstones extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth');
        } else if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
        $this->load->helper('my'); // Load Library Ignited-Datatables
        $this->load->model('Master_model', 'master');
        $this->load->model('Cornerstones_model', 'cornerstones');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function index()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user' => $user,
            'judul'    => 'Cornerstones',
            'subjudul' => 'Data Cornerstones'
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/cornerstones/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function data()
    {
        $this->output_json($this->cornerstones->getDatacornerstones(), false);
    }

    // public function validasi()
    // {
    //     $this->form_validation->set_rules('title', 'title', 'required');
    // }

    public function file_config()
    {
        $allowed_type     = [
            "image/jpeg", "image/jpg", "image/png", "image/gif",
        ];
        $config['upload_path']      = FCPATH . 'uploads/cornerstones/';
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['encrypt_name']     = TRUE;

        return $this->load->library('upload', $config);
    }

    public function add()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Cornerstones',
            'subjudul'  => 'Tambah data'
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/cornerstones/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function edit($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Cornerstones',
            'subjudul'  => 'Edit Data',
            'cornerstones'      => $this->cornerstones->getDataCornerstonesById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/cornerstones/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function save()
    {
        $this->file_config();
        $method     = $this->input->post('method', true);
        $cornerstones_id     = $this->input->post('cornerstones_id', true);
        $title = $this->input->post('title', true);
        $description = $this->input->post('description', true);
        $link = $this->input->post('link', true);

        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('link', 'Link', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');


        if ($this->form_validation->run() === FALSE) {
            $data = [
                'status'    => false,
                'errors'    => [
                    'title' => form_error('title'),
                    'description' => form_error('description'),
                    'link' => form_error('link'),
                ]
            ];
            $this->output_json($data);
        } else {
            $data = [
                'title'     => $title,
                'description'     => $description,
                'link'     => $link,
                'created_on'     => date('Y-m-d'),
                'updated_on'     => date('Y-m-d'),
            ];

            $i = 0;
            foreach ($_FILES as $key => $val) {
                $img_src = FCPATH . 'uploads/cornerstones/';
                $getcornerstones = $this->cornerstones->getDataCornerstonesById($this->input->post('cornerstones_id', true));

                $error = '';
                if ($key === 'photo') {
                    if (!empty($_FILES['photo']['name'])) {
                        if (!$this->upload->do_upload('photo')) {
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File slider Error');
                            exit();
                        } else {
                            if ($method === 'edit') {
                                if (!unlink($img_src . $getcornerstones->photo)) {
                                    show_error('Error saat delete file <br/>' . var_dump($getcornerstones), 500, 'Error Edit file');
                                    exit();
                                }
                            }
                            $data['photo'] = $this->upload->data('file_name');
                            $data['tipe_file'] =  $img_src;
                        }
                    }
                } else {
                    if (!$this->upload->do_upload($key)) {
                        $error = $this->upload->display_errors();
                        show_error($error, 500);
                        exit();
                    } else {
                        if ($method === 'edit') {
                            if (!unlink($img_src . $getcornerstones)) {
                                show_error('Error saat delete file', 500, 'Error Edit file');
                                exit();
                            }
                        }
                        $data = [
                            'title'      => $this->input->post('title', true),
                        ];
                        $data['photo'] = $this->upload->data('file_name');
                        $data['tipe_file'] =  $img_src;
                    }
                    $i++;
                }
            }

            if ($method === 'add') {
                //push array
                $data['created_on'] = date('Y-m-d');
                $data['updated_on'] = date('Y-m-d');
                //insert data
                $action = $this->master->create('tb_cornerstones', $data);
            } else if ($method === 'edit') {
                //push array
                $data['updated_on'] = date('Y-m-d');
                //update data
                $cornerstones_id = $this->input->post('cornerstones_id', true);
                $action = $this->master->update('tb_cornerstones', $data, 'cornerstones_id', $cornerstones_id);
            } else {
                show_error('Method tidak diketahui', 404);
            }

            if ($action) {
                $this->output_json(['status' => true]);
            } else {
                $this->output_json(['status' => false]);
            }
            // redirect('admin/slider');
        }
    }


    public function delete($id)
    {
        $input = [
            'deleted_on'    => date('Y-m-d'),
        ];
        // var_dump($input);
        // exit();
        $action = $this->master->update('tb_cornerstones', $input, 'cornerstones_id', $id);
        if ($action) {
            $this->output_json(['status' => true]);
        } else {
            $this->output_json(['status' => false]);
        }
         redirect('admin/cornerstones');
    }
}

/* End of file cornerstones.php */
