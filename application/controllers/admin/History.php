<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History extends CI_Controller
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
        $this->load->model('History_model', 'history');
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
            'judul'    => 'History',
            'subjudul' => 'Data history'
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/history/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function data()
    {
        $this->output_json($this->history->getDataHistory(), false);
    }

    public function add()
    {
        $data = [
            'user' => $this->ion_auth->user()->row(),
            'judul'    => 'Our History',
            'subjudul' => 'Tambah Data history',
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/history/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function save()
    {
        $method     = $this->input->post('method', true);
        $history_id     = $this->input->post('history_id', true);
        $year         = $this->input->post('year', true);
        $subyear = $this->input->post('subyear', true);
        $description         = $this->input->post('description', true);
       
       
        $this->form_validation->set_rules('year', 'Year', 'required|trim');
        $this->form_validation->set_rules('subyear', 'Subyear', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');
       

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'status'    => false,
                'errors'    => [
                    'year' => form_error('year'),
                    'subyear' => form_error('subyear'),
                    'description' => form_error('description'),
                ]
            ];
            $this->output_json($data);
        } else {
            $input = [
                'year'            => $year,
                'subyear'     => $subyear,
                'description'         => $description,
                'created_on'     => date('Y-m-d'),
                'updated_on'     => date('Y-m-d'),
            ];
            if ($method === 'add') {
                $action = $this->master->create('tb_history', $input);
            } else if ($method === 'edit') {
                $action = $this->master->update('tb_history', $input, 'history_id', $history_id);
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
            'judul'        => 'Our History',
            'subjudul'    => 'Edit Data history',
            'data'         => $this->history->getHistoryById($id)
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/history/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function delete($id)
    {
        $input = [
            'deleted_on'    => date('Y-m-d'),
        ];
        // var_dump($input);
        // exit();
        $action = $this->master->update('tb_history', $input, 'history_id', $id);
        if ($action) {
            $this->output_json(['status' => true]);
        } else {
            $this->output_json(['status' => false]);
        }
        redirect('admin/history');
    }
}
