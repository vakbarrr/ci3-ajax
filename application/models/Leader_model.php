<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Leader_model extends CI_Model
{
    public function getDataLeader()
    {
        $this->datatables->select('leader_id, name,about, qualification, relevant_working, present_director');
        $this->datatables->where('deleted_on', NULL);
        $this->datatables->from('tb_leaders');
        return $this->datatables->generate();
    }

    public function getDataLeaderById($id)
    {
        $query = $this->db->get_where('tb_leaders', array('leader_id' => $id));
        return $query->row();
    }
}

/* End of file Award_model.php */
