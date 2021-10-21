<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Journey_model extends CI_Model
{

    public function getDataJourney()
    {
        $this->datatables->select('journey_id, journey_title, journey_content, journey_date, photos');
        $this->datatables->where('deleted_on', NULL);
        $this->datatables->from('tb_journey');
        return $this->datatables->generate();
    }

    public function getDataJourneyById($id)
    {
        $query = $this->db->get_where('tb_journey', array('journey_id' => $id));
        return $query->row();
    }

}

/* End of file Award_model.php */
