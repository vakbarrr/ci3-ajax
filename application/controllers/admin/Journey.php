<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Journey extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        } else if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
        $this->load->model('Master_model', 'master');
        $this->load->helper('my'); // Load Library Ignited-Datatables
        $this->load->model('Journey_model', 'journey');
        $this->form_validation->set_error_delimiters('', '');
    }


    public function index()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user' => $user,
            'judul'    => 'Journey',
            'subjudul' => 'Data Journey'
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/journey/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }


    public function add()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Journey',
            'subjudul'  => 'Tambah data file Journey',
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/journey/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }


    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function data()
    {
        $this->output_json($this->journey->getDataJourney(), false);
    }

    public function file_config()
    {
        $allowed_type     = [
            "image/jpeg", "image/jpg", "image/png", "image/gif",
        ];
        $config['upload_path']      = FCPATH . 'uploads/journey/';
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['encrypt_name']     = TRUE;

        return $this->load->library('upload', $config);
    }


    public function save()
    {
        $this->file_config();
        $method     = $this->input->post('method', true);
        $journey_id     = $this->input->post('journey_id', true);
        $journey_title = $this->input->post('journey_title', true);
        $journey_content = $this->input->post('journey_content', true);
        $journey_date = $this->input->post('journey_date', true);
       

        $this->form_validation->set_rules('journey_title', 'Journey title', 'required|trim');
        $this->form_validation->set_rules('journey_date', 'Journey date', 'required|trim');
        $this->form_validation->set_rules('journey_content', 'Journey content', 'required|trim');
      
        if ($this->form_validation->run() === FALSE) {
            $data = [
                'status'    => false,
                'errors'    => [
                    'journey_title' => form_error('journey_title'),
                    'journey_content' => form_error('journey_content'),
                    'journey_date' => form_error('journey_date'),
                    'category_id' => form_error('category_id'),
                    // 'slug' => form_error('slug'),
                ]
            ];
            $this->output_json($data);
        } else {
            $data = [
                'journey_title'     => $journey_title,
                'journey_content'     => $journey_content,
                'journey_date'     => $journey_date,
                // 'slug'     => $slug,
            ];

            $i = 0;
            foreach ($_FILES as $key => $val) {
                $img_src = FCPATH . 'uploads/journey/';
                $getjourney = $this->journey->getDataJourneyById($this->input->post('journey_id', true));
                $error = '';
                if ($key === 'photo') {
                    if (!empty($_FILES['photo']['name'])) {
                        if (!$this->upload->do_upload('photo')) {
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File slider Error');
                            exit();
                        } else {
                            if ($method === 'edit') {
                                if (!unlink($img_src . $getjourney->photos)) {
                                    show_error('Error saat delete file <br/>' . var_dump($getjourney), 500, 'Error Edit file');
                                    exit();
                                }
                            }
                            $data['photos'] = $this->upload->data('file_name');
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
                            if (!unlink($img_src . $getjourney)) {
                                show_error('Error saat delete file', 500, 'Error Edit file');
                                exit();
                            }
                        }
                        $data = [
                            'journey_title'     => $journey_title,
                            'journey_content'     => $journey_content,
                            'journey_date'     => $journey_date,
                            // 'slug'     => $slug;
                        ];
                        $data['photos'] = $this->upload->data('file_name');
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
                $action = $this->master->create('tb_journey', $data);
            } else if ($method === 'edit') {
                //push array
                $data['updated_on'] = date('Y-m-d');
                //update data
                $journey_id = $this->input->post('journey_id', true);
                $action = $this->master->update('tb_journey', $data, 'journey_id', $journey_id);
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
            'deleted_on'    => date('Y-m-d')
        ];
        // var_dump($input);
        // exit();
        if ($this->master->update('tb_journey', $input, 'journey_id', $id)) {
            $this->output_json(['status' => true]);
        }
        redirect('admin/journey');
    }

    public function edit($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Journey',
            'subjudul'  => 'Edit Data Journey',
            'journey'      => $this->journey->getDataJourneyById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/journey/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }
}

/* End of file journey.php */
