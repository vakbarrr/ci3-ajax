<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Insight extends CI_Controller {

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
        $this->load->model('Insight_model', 'insight');
        $this->form_validation->set_error_delimiters('', '');
    }


    public function index()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user' => $user,
            'judul'    => 'Insight',
            'subjudul' => 'Data Insight'
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/insight/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }
   

    public function add()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Insight',
            'subjudul'  => 'Tambah data file Insight',
            'category' => $this->insight->getAllCategory()
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/insight/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }


    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function data()
    {
        $this->output_json($this->insight->getDataInsight(), false);
    }

    public function file_config()
    {
        $allowed_type     = [
            "image/jpeg", "image/jpg", "image/png", "image/gif",
        ];
        $config['upload_path']      = FCPATH . 'uploads/insight/';
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['encrypt_name']     = TRUE;

        return $this->load->library('upload', $config);
    }


    public function save()
    {
        $this->file_config();
        $method     = $this->input->post('method', true);
        $insight_id     = $this->input->post('insight_id', true);
        $insight_title = $this->input->post('insight_title', true);
        $insight_content = $this->input->post('insight_content', true);
        $insight_date = $this->input->post('insight_date', true);
        $category_id = $this->input->post('category_id', true);


        $this->form_validation->set_rules('insight_title', 'Title insight', 'required|trim');
        $this->form_validation->set_rules('insight_date', 'Insight date', 'required|trim');
        $this->form_validation->set_rules('insight_content', 'Insight content', 'required|trim');
        $this->form_validation->set_rules('category_id', 'Category insight', 'required|trim');
    


        if ($this->form_validation->run() === FALSE) {
            $data = [
                'status'    => false,
                'errors'    => [
                    'insight_title' => form_error('insight_title'),
                    'insight_content' => form_error('insight_content'),
                    'insight_date' => form_error('insight_date'),
                    'category_id' => form_error('category_id'),
                    // 'slug' => form_error('slug'),
                ]
            ];
            $this->output_json($data);
        } else {
            $data = [
                'insight_title'     => $insight_title,
                'insight_content'     => $insight_content,
                'insight_date'     => $insight_date,
                'category_id'     => $category_id,
                // 'slug'     => $slug,
            ];

            $i = 0;
            foreach ($_FILES as $key => $val) {
                $img_src = FCPATH . 'uploads/insight/';
                $getinsight = $this->insight->getDataInsightById($this->input->post('insight_id', true));
                $error = '';
                if ($key === 'photo') {
                    if (!empty($_FILES['photo']['name'])) {
                        if (!$this->upload->do_upload('photo')) {
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File slider Error');
                            exit();
                        } else {
                            if ($method === 'edit') {
                                if (!unlink($img_src . $getinsight->photos)) {
                                    show_error('Error saat delete file <br/>' . var_dump($getinsight), 500, 'Error Edit file');
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
                            if (!unlink($img_src . $getinsight)) {
                                show_error('Error saat delete file', 500, 'Error Edit file');
                                exit();
                            }
                        }
                        $data = [
                            'insight_title'     => $insight_title,
                            'insight_content'     => $insight_content,
                            'insight_date'     => $insight_date,
                            'category_id'     => $category_id,
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
                $action = $this->master->create('tb_insight', $data);
            } else if ($method === 'edit') {
                //push array
                $data['updated_on'] = date('Y-m-d');
                //update data
                $insight_id = $this->input->post('insight_id', true);
                $action = $this->master->update('tb_insight', $data, 'insight_id', $insight_id);
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
        if ($this->master->update('tb_insight', $input, 'insight_id', $id)) {
            $this->output_json(['status' => true]);
        }
        redirect('admin/insight');
    }



    public function edit($id)
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Insight',
            'subjudul'  => 'Edit Data insight',
            'insight'      => $this->insight->getDataInsightById($id),
            'category' => $this->insight->getAllCategory()
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/insight/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }


    public function datacategory()
    {
        $this->output_json($this->insight->getDataCategory(), false);
    }
    public function category()
    {
        $data = [
            'user' => $this->ion_auth->user()->row(),
            'judul'    => 'Our Insight',
            'subjudul' => 'Data category'
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/category/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    

    public function addcategory()
    {
        $data = [
            'user' => $this->ion_auth->user()->row(),
            'judul'    => 'Our Insight',
            'subjudul' => 'Tambah Data category',
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/category/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function savecategory()
    {
        $method     = $this->input->post('method', true);
        $category_id     = $this->input->post('category_id', true);
        $category_name         = $this->input->post('category_name', true);
       

        $this->form_validation->set_rules('category_name', 'category_name', 'required|trim');
   


        if ($this->form_validation->run() == FALSE) {
            $data = [
                'status'    => false,
                'errors'    => [
                    'category_name' => form_error('category_name'),
                ]
            ];
            $this->output_json($data);
        } else {
            $input = [
                'category_name'            => $category_name,
                'created_on'     => date('Y-m-d'),
                'updated_on'     => date('Y-m-d'),
            ];
            if ($method === 'add') {
                $action = $this->master->create('tb_category', $input);
            } else if ($method === 'edit') {
                $action = $this->master->update('tb_category', $input, 'category_id', $category_id);
            }

            if ($action) {
                $this->output_json(['status' => true]);
            } else {
                $this->output_json(['status' => false]);
            }
        }
    }

    public function editcategory($id)
    {
        $data = [
            'user'         => $this->ion_auth->user()->row(),
            'judul'        => 'Our Insight',
            'subjudul'    => 'Edit Data category',
            'data'         => $this->insight->getDataCategoryById($id)
        ];
        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/category/edit');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function deletecategory($id)
    {
        $input = [
            'deleted_on'    => date('Y-m-d'),
        ];
        // var_dump($input);
        // exit();
        $action = $this->master->update('tb_category', $input, 'category_id', $id);
        if ($action) {
            $this->output_json(['status' => true]);
        } else {
            $this->output_json(['status' => false]);
        }
        redirect('admin/category');
    }


}

/* End of file Insight.php */
