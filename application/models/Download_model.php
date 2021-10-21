<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Download_model extends CI_Model
{
    public function getDataDownload()
    {
        $this->datatables->select('download_id, title, file');
        $this->datatables->where('deleted_on', NULL);
        $this->datatables->from('tb_download');
        return $this->datatables->generate();
    }

    public function getDataDownloadById($id)
    {
        $query = $this->db->get_where('tb_download', array('download_id' => $id));
        return $query->row();
    }
}

/* End of file Award_model.php */
