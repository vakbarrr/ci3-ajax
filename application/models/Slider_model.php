<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Slider_model extends CI_Model {

    public function getDataSlider()
    {
        $this->datatables->select('slider_id, title, photo');
        $this->datatables->from('tb_slider');
         $this->datatables->where('deleted_on', NULL);
        $this->datatables->add_column('bulk_select', '<div class="text-center"><input type="checkbox" class="check" name="checked[]" value="$1"/></div>', 'slider_id, title, photo');
        return $this->datatables->generate();
    }


    public function getDataSliderById($id)
    {
        return $this->db->get_where('tb_slider', ['slider_id' => $id])->row();
    }


}

/* End of file Slider_model.php */
