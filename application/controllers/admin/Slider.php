<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller {


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
        $this->load->model('Slider_model', 'slider');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function index()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user' => $user,
            'judul'    => 'Slider',
            'subjudul' => 'Data slider'
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/slider/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function data()
    {
        $this->output_json($this->slider->getDataSlider(), false);
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
        $config['upload_path']      = FCPATH . 'uploads/slider/';
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['encrypt_name']     = TRUE;

        return $this->load->library('upload', $config);
    }
    public function add()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Slider',
            'subjudul'  => 'Tambah data slider'
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/slider/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }
    
    public function edit($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Slider',
            'subjudul'  => 'Edit Data slider',
            'slider'      => $this->slider->getDataSliderById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/slider/edit');
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
            ];

            $i = 0;
            foreach ($_FILES as $key => $val) {
                $img_src = FCPATH . 'uploads/slider/';
                $getslider = $this->slider->getDataSliderById($this->input->post('slider_id', true));

                $error = '';
                if ($key === 'file_slider') {
                    if (!empty($_FILES['file_slider']['name'])) {
                        if (!$this->upload->do_upload('file_slider')) {
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File slider Error');
                            exit();
                        } else {
                            if ($method === 'edit') {
                                if (!unlink($img_src . $getslider->photo)) {
                                    show_error('Error saat delete file <br/>' . var_dump($getslider), 500, 'Error Edit file');
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
                            if (!unlink($img_src . $getslider)) {
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
                $action = $this->master->create('tb_slider', $data);
            } else if ($method === 'edit') {
                //push array
                $data['updated_on'] = date('Y-m-d');
                //update data
                $slider_id = $this->input->post('slider_id', true);
                $action = $this->master->update('tb_slider', $data, 'slider_id', $slider_id);
            } else {
                show_error('Method tidak diketahui', 404);
            }
            
            if ($action) {
                $this->output_json(['status' => true]);
            } else {
                $this->output_json(['status' => false]);
            }
             redirect('admin/slider');
        }
    }

    public function delete($id)
    {
        $input = [
            'deleted_on'    => date('Y-m-d')
        ];
        // var_dump($input);
        // exit();
        if ($this->master->update('tb_slider', $input, 'slider_id', $id)) {
            $this->output_json(['status' => true]);
            
        }
        redirect('admin/slider');
    }
}

/* End of file Slider.php */
