<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Leader extends CI_Controller {

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
        $this->load->model('Leader_model', 'leader');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function index()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user' => $user,
            'judul'    => 'Our Leader',
            'subjudul' => 'Data leader'
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/leader/data');
        $this->load->view('_templates/dashboard/_footer.php');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function data()
    {
        $this->output_json($this->leader->getDataLeader(), false);
    }

    public function add()
    {
        $user = $this->ion_auth->user()->row();
        $data = [
            'user'      => $user,
            'judul'        => 'Our leader',
            'subjudul'  => 'Tambah data'
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
        $this->load->view('admin/leader/add');
        $this->load->view('_templates/dashboard/_footer.php');
    }
    public function file_config()
    {
        $allowed_type     = [
            "image/jpeg", "image/jpg", "image/png", "image/gif",
        ];
        $config['upload_path']      = FCPATH . 'uploads/leaders/';
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['encrypt_name']     = TRUE;

        return $this->load->library('upload', $config);
    }
  
    public function save()
    {
        $this->file_config();
        $method     = $this->input->post('method', true);
        $leader_id     = $this->input->post('leader_id', true);
        $name = $this->input->post('name', true);
        $about = $this->input->post('about', true);
        $qualification = $this->input->post('qualification', true);
        $relevant_working = $this->input->post('relevant_working', true);
        $present_director = $this->input->post('present_director', true);
        $grup_leaders = $this->input->post('grup_leaders', true);

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('qualification', 'Qualification', 'required|trim');
        $this->form_validation->set_rules('about', 'About', 'required|trim');
        $this->form_validation->set_rules('relevant_working', 'Relevant working', 'required|trim');
        $this->form_validation->set_rules('present_director', 'Present director', 'required|trim');
        $this->form_validation->set_rules('grup_leaders', 'Grup of leaders', 'required|trim');


        if ($this->form_validation->run() === FALSE) {
            $data = [
                'status'    => false,
                'errors'    => [
                    'name' => form_error('name'),
                    'about' => form_error('about'),
                    'qualification' => form_error('qualification'),
                    'relevant_working' => form_error('relevant_working'),
                    'present_director' => form_error('present_director'),
                    'grup_leaders' => form_error('grup_leaders'),
                ]
            ];
            $this->output_json($data);
        } else {
            $data = [
                'name'     => $name,
                'about'     => $about,
                'qualification'     => $qualification,
                'relevant_working'     => $relevant_working,
                'present_director'     => $present_director,
                'grup_leaders'     => $grup_leaders,
            ];

            $i = 0;
            foreach ($_FILES as $key => $val) {
                $img_src = FCPATH . 'uploads/leaders/';
                $getleader = $this->leader->getDataLeaderById($this->input->post('leader_id', true));

                $error = '';
                if ($key === 'photo') {
                    if (!empty($_FILES['photo']['name'])) {
                        if (!$this->upload->do_upload('photo')) {
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File slider Error');
                            exit();
                        } else {
                            if ($method === 'edit') {
                                if (!unlink($img_src . $getleader->photo)) {
                                    show_error('Error saat delete file <br/>' . var_dump($getleader), 500, 'Error Edit file');
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
                            if (!unlink($img_src . $getleader)) {
                                show_error('Error saat delete file', 500, 'Error Edit file');
                                exit();
                            }
                        }
                        $data = [
                            'name'     => $name,
                            'about'     => $about,
                            'qualification'     => $qualification,
                            'relevant_working'     => $relevant_working,
                            'present_director'     => $present_director,
                            'grup_leaders'     => $grup_leaders,
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
                $action = $this->master->create('tb_leaders', $data);
            } else if ($method === 'edit') {
                //push array
                $data['updated_on'] = date('Y-m-d');
                //update data
                $leader_id = $this->input->post('leader_id', true);
                $action = $this->master->update('tb_leaders', $data, 'leader_id', $leader_id);
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
        $action = $this->master->update('tb_leader', $input, 'leader_id', $id);
        if ($action) {
            $this->output_json(['status' => true]);
        } else {
            $this->output_json(['status' => false]);
        }
        redirect('admin/leader');
    }
}

/* End of file Leader.php */
