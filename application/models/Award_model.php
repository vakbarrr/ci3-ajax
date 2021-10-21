<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Award_model extends CI_Model
{
    public function getDataAward()
    {
        $this->datatables->select('award_id, title, year, description');
        $this->datatables->where('deleted_on', NULL);
        $this->datatables->from('tb_award');
        return $this->datatables->generate();
    }

    public function getAwardById($id)
    {
        $query = $this->db->get_where('tb_award', array('award_id' => $id));
        return $query->row();
    }
}

/* End of file Award_model.php */
