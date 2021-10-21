<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Insight_model extends CI_Model
{

    public function getDataInsight()
    {
        $this->datatables->select('insight_id, insight_title, insight_content, insight_date, category_id, photos');
        $this->datatables->where('deleted_on', NULL);
        $this->datatables->from('tb_insight');
        return $this->datatables->generate();
    }

    public function getDataInsightById($id)
    {
        $query = $this->db->get_where('tb_insight', array('insight_id' => $id));
        return $query->row();
    }

    public function getDataCategory()
    {
        $this->datatables->select('category_id, category_name');
        $this->datatables->where('deleted_on', NULL);
        $this->datatables->from('tb_category');
        return $this->datatables->generate();
    }

    public function getDataCategoryById($id)
    {
        $query = $this->db->get_where('tb_category', array('category_id' => $id));
        return $query->row();
    }

    public function getAllCategory()
    {
        return $this->db->get('tb_category')->result();
    }
}

/* End of file Award_model.php */
