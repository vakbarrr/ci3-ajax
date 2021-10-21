<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model {

    public function getDataVideo()
    {
        $this->datatables->select('video_id, title, video_link');
        $this->datatables->where('deleted_on', NULL);
        $this->datatables->from('tb_video');
        return $this->datatables->generate();
    }


    public function getDataVideoById($id)
    {
        $query = $this->db->get_where('tb_video', array('video_id' => $id));
        return $query->row();
    }
}

/* End of file Video_model.php */
