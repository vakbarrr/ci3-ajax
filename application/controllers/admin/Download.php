<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Download extends CI_Controller
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
        $this->load->model('Download_model', 'download');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function index()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user' => $user,
            'judul'    => 'Download',
            'subjudul' => 'Data file download'
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/download/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function data()
    {
        $this->output_json($this->download->getDataDownload(), false);
    }

    // public function validasi()
    // {
    //     $this->form_validation->set_rules('title', 'title', 'required');
    // }

    public function file_config()
    {
        $allowed_type     = [
            "application/pdf", "application/docx", "application/doc", "application/xslx",
        ];
        $config['upload_path']      = FCPATH . 'uploads/download/';
        $config['allowed_types']    = 'pdf|docs|docx|xslx';
        $config['encrypt_name']     = TRUE;

        return $this->load->library('upload', $config);
    }
    public function save()
    {
        $this->file_config();
        $method     = $this->input->post('method', true);
        $download_id     = $this->input->post('download_id', true);
        $title = $this->input->post('title', true);

        $this->form_validation->set_rules('itle', 'Title', 'required|trim');


        if ($this->form_validation->run() === FALSE) {
            $data = [
                'status'    => false,
                'errors'    => [
                    'title' => form_error('title'),
                ]
            ];
            $this->output_json($data);
        } else {
            $data = [
                'title'     => $title,

            ];

            $i = 0;
            foreach ($_FILES as $key => $val) {
                $img_src = FCPATH . 'uploads/download/';
                $getdownload = $this->download->getDataDownloadById($this->input->post('download_id', true));

                $error = '';
                if ($key === 'file_download') {
                    if (!empty($_FILES['file_download']['name'])) {
                        if (!$this->upload->do_upload('file_download')) {
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File slider Error');
                            exit();
                        } else {
                            if ($method === 'edit') {
                                if (!unlink($img_src . $getdownload->file)) {
                                    show_error('Error saat delete file <br/>' . var_dump($getdownload), 500, 'Error Edit file');
                                    exit();
                                }
                            }
                            $data['file'] = $this->upload->data('file_name');
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
                            if (!unlink($img_src . $getdownload)) {
                                show_error('Error saat delete file', 500, 'Error Edit file');
                                exit();
                            }
                        }
                        $data = [
                            'title'     => $title,

                        ];
                        $data['file'] = $this->upload->data('file_name');
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
                $action = $this->master->create('tb_download', $data);
            } else if ($method === 'edit') {
                //push array
                $data['updated_on'] = date('Y-m-d');
                //update data
                $download_id = $this->input->post('download_id', true);
                $action = $this->master->update('tb_download', $data, 'download_id', $download_id);
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

    public function add()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Download',
            'subjudul'  => 'Tambah data file download'
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/download/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function edit($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Download',
            'subjudul'  => 'Edit Data file download',
            'download'      => $this->download->getDataDownloadById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/download/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }



    public function delete($id)
    {
        $input = [
            'deleted_on'    => date('Y-m-d'),
        ];
        // var_dump($input);
        // exit();
        $action = $this->master->update('tb_download', $input, 'download_id', $id);
        if ($action) {
            $this->output_json(['status' => true]);
        } else {
            $this->output_json(['status' => false]);
        }
        redirect('admin/download');
    }
}

/* End of file download.php */
