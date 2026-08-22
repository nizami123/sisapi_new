<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah extends CI_Controller {

	public function ajax($tingkat, $parent_id)
	{
		$data = array();
		switch ($tingkat) {
			case 'kabupaten': $data = $this->Wilayah_model->get_kabupaten($parent_id); break;
			case 'kecamatan': $data = $this->Wilayah_model->get_kecamatan($parent_id); break;
			case 'desa':      $data = $this->Wilayah_model->get_desa($parent_id); break;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}
