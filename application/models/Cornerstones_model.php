<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cornerstones_model extends CI_Model
{
    public function getDataCornerstones()
    {
        $this->datatables->select('cornerstones_id, title, description, link, photo');
        $this->datatables->where('deleted_on', NULL);
        $this->datatables->from('tb_cornerstones');
        return $this->datatables->generate();
    }

    public function getDataCornerstonesById($id)
    {
        $query = $this->db->get_where('tb_cornerstones', array('cornerstones_id' => $id));
        return $query->row();
    }
}

/* End of file Award_model.php */
