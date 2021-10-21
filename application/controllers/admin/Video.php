<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends CI_Controller {

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
        $this->load->model('Video_model', 'video');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function index()
    {
        $data = [
            'user' => $this->ion_auth->user()->row(),
            'judul'    => 'Video',
            'subjudul' => 'Data video'
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/video/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function data()
    {
        $this->output_json($this->video->getDataVideo(), false);
    }

    public function add()
    {
        $data = [
            'user' => $this->ion_auth->user()->row(),
            'judul'    => 'Tambah video',
            'subjudul' => 'Tambah Data video',
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/video/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function edit($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'video',
            'subjudul'  => 'Edit Data video',
            'data'      => $this->video->getDataVideoById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/video/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function save()
    {
        $method     = $this->input->post('method', true);
        $title     = $this->input->post('title', true);
        $video_link = $this->input->post('video_link', true);
        $video_id = $this->input->post('video_id', true);

        
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('video_link', 'Link Video', 'required');
    

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'status'    => false,
                'errors'    => [
                    'video_link' => form_error('video_link'),
                    'title' => form_error('title'),
                ]
            ];
            $this->output_json($data);
        } else {
            $input = [
                'title'            =>$title ,
                'video_link'     => $video_link,
                'created_on'    => date('Y-m-d'),
                'updated_on'    => date('Y-m-d')
            ];
            if ($method === 'add') {
                $action = $this->master->create('tb_video', $input);
            } else if ($method === 'edit') {
                $input = [
                    'title'            => $title,
                    'video_link'     => $video_link,
                    'updated_on'    => date('Y-m-d')
                ];
                $action = $this->master->update('tb_video', $input, 'video_id', $video_id);
            }

            if ($action) {
                $this->output_json(['status' => true]);
            } else {
                $this->output_json(['status' => false]);
            }
        }
    }

    public function delete($id)
    {
        $input = [
            'deleted_on'    => date('Y-m-d'),
        ];
        // var_dump($input);
        // exit();
        $action = $this->master->update('tb_video', $input, 'video_id', $id);
        if ($action) {
            $this->output_json(['status' => true]);
        } else {
            $this->output_json(['status' => false]);
        }
        redirect('admin/video');
    }

}

/* End of file Video.php */
