<?php

defined('BASEPATH') or exit('No direct script access allowed');

class About extends CI_Controller
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
        $this->load->model('About_model', 'about');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function index()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user' => $user,
            'judul'    => 'About',
            'subjudul' => 'Data about'
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/about/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function data()
    {
        $this->output_json($this->about->getDataAbout(), false);
    }

    public function validasi()
    {
        $this->form_validation->set_rules('title', 'title', 'required');
    }

    public function file_config()
    {
        $allowed_type     = [
            "image/jpeg", "image/jpg", "image/png", "image/gif",
        ];
        $config['upload_path']      = FCPATH . 'uploads/about/';
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['encrypt_name']     = TRUE;

        return $this->load->library('upload', $config);
    }
    public function add()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'About',
            'subjudul'  => 'Tambah data about'
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/about/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function edit($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'About',
            'subjudul'  => 'Edit data about',
            'about'      => $this->about->getDataAboutById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/about/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function save()
    {
        $method = $this->input->post('method', true);
        $this->validasi();
        $this->file_config();

        if ($this->form_validation->run() === FALSE) {
            $method === 'add' ? $this->add() : $this->edit();
        } else {
            $data = [
                'title'      => $this->input->post('title', true),
                'link'      => $this->input->post('link', true),
                'header'      => $this->input->post('header', true),
            ];

            $i = 0;
            foreach ($_FILES as $key => $val) {
                $img_src = FCPATH . 'uploads/about/';
                $getabout = $this->about->getDataAboutById($this->input->post('about_id', true));

                $error = '';
                if ($key === 'file_about') {
                    if (!empty($_FILES['file_about']['name'])) {
                        if (!$this->upload->do_upload('file_about')) {
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File about Error');
                            exit();
                        } else {
                            if ($method === 'edit') {
                                if (!unlink($img_src . $getabout->photo)) {
                                    show_error('Error saat delete file <br/>' . var_dump($getabout), 500, 'Error Edit file');
                                    exit();
                                }
                            }
                            $data['photo'] = $this->upload->data('file_name');
                            $data['tipe_file'] = $this->upload->data('file_type');
                        }
                    }
                } else {
                    if (!$this->upload->do_upload($key)) {
                        $error = $this->upload->display_errors();
                        show_error($error, 500);
                        exit();
                    } else {
                        if ($method === 'edit') {
                            if (!unlink($img_src . $getabout)) {
                                show_error('Error saat delete file', 500, 'Error Edit file');
                                exit();
                            }
                        }
                        $data = [
                            'title'      => $this->input->post('title', true),
                            'link'      => $this->input->post('link', true),
                            'header'      => $this->input->post('header', true),
                        ];
                        $data['photo'] = $this->upload->data('file_name');
                        $data['tipe_file'] = $this->upload->data('file_type');
                    }
                    $i++;
                }
            }

            if ($method === 'add') {
                //push array
                $data['created_on'] = date('Y-m-d');
                $data['updated_on'] = date('Y-m-d');
                //insert data
                $this->master->create('tb_about', $data);
            } else if ($method === 'edit') {
                //push array
                $data['updated_on'] = date('Y-m-d');
                //update data
                $about_id = $this->input->post('about_id', true);
                $this->master->update('tb_about', $data, 'about_id', $about_id);
            } else {
                show_error('Method tidak diketahui', 404);
            }
            redirect('admin/about');
        }
    }

    public function delete($id)
    {
        $input = [
            'deleted_on'    => date('Y-m-d')
        ];
        // var_dump($input);
        // exit();
        if ($this->master->update('tb_about', $input, 'about_id', $id)) {
            $this->output_json(['status' => true]);
        }
        redirect('admin/about');
    }
}

/* End of file about.php */
