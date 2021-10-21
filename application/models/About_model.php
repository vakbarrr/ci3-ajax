<?php

defined('BASEPATH') or exit('No direct script access allowed');

class About_model extends CI_Model
{
    public function getDataAbout()
    {
        $this->datatables->select('about_id,title, header, link, photo');
        $this->datatables->from('tb_about');
        $this->datatables->where('deleted_on', NULL);
        $this->datatables->add_column('bulk_select', '<div class="text-center"><input type="checkbox" class="check" name="checked[]" value="$1"/></div>', 'about_id, title, header, link, photo');
        return $this->datatables->generate();
    }

    public function getDataAboutById($id)
    {
        return $this->db->get_where('tb_about', ['about_id' => $id])->row();
    }
}

/* End of file About_model.php */
