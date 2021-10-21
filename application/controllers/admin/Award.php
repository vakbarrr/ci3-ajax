<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Award extends CI_Controller
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
        $this->load->model('Award_model', 'award');
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
            'judul'    => 'Our Awards',
            'subjudul' => 'Data award'
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/award/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function data()
    {
        $this->output_json($this->award->getDataAward(), false);
    }

    public function add()
    {
        $data = [
            'user' => $this->ion_auth->user()->row(),
            'judul'    => 'Our Awards',
            'subjudul' => 'Tambah Data award',
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/award/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function save()
    {
        $method     = $this->input->post('method', true);
        $award_id     = $this->input->post('award_id', true);
        $year         = $this->input->post('year', true);
        $title = $this->input->post('title', true);
        $description         = $this->input->post('description', true);
       
       
        $this->form_validation->set_rules('year', 'Year', 'required|trim');
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');
       

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'status'    => false,
                'errors'    => [
                    'year' => form_error('year'),
                    'title' => form_error('title'),
                    'description' => form_error('description'),
                ]
            ];
            $this->output_json($data);
        } else {
            $input = [
                'year'            => $year,
                'title'     => $title,
                'description'         => $description,
                'created_on'     => date('Y-m-d'),
                'updated_on'     => date('Y-m-d'),
            ];
            if ($method === 'add') {
                $action = $this->master->create('tb_award', $input);
            } else if ($method === 'edit') {
                $action = $this->master->update('tb_award', $input, 'award_id', $award_id);
            }

            if ($action) {
                $this->output_json(['status' => true]);
            } else {
                $this->output_json(['status' => false]);
            }
        }
    }

    public function edit($id)
    {
        $data = [
            'user'         => $this->ion_auth->user()->row(),
            'judul'        => 'Our award',
            'subjudul'    => 'Edit Data award',
            'data'         => $this->award->getAwardById($id)
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/award/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function delete($id)
    {
        $input = [
            'deleted_on'    => date('Y-m-d'),
        ];
        // var_dump($input);
        // exit();
        $action = $this->master->update('tb_award', $input, 'award_id', $id);
        if ($action) {
            $this->output_json(['status' => true]);
        } else {
            $this->output_json(['status' => false]);
        }
        redirect('admin/award');
    }
}
