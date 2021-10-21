<?php

defined('BASEPATH') or exit('No direct script access allowed');

class History_model extends CI_Model
{
    public function getDataHistory()
    {
        $this->datatables->select('history_id, year, subyear, description');
        $this->datatables->where('deleted_on', NULL);
        $this->datatables->from('tb_history');
        return $this->datatables->generate();
    }

    public function getHistoryById($id)
    {
        $query = $this->db->get_where('tb_history', array('history_id' => $id));
        return $query->row();
    }
}

/* End of file History_model.php */
