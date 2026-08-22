<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_model extends CI_Model {

	protected $table = 'banner';

	public function get_active()
	{
		return $this->db->where('status', 1)->order_by('urutan', 'ASC')->get($this->table)->result();
	}

	public function get_all()
	{
		return $this->db->order_by('urutan', 'ASC')->get($this->table)->result();
	}

	public function create($data)
	{
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		return $this->db->where('id', $id)->update($this->table, $data);
	}

	public function delete($id)
	{
		return $this->db->where('id', $id)->delete($this->table);
	}
}
