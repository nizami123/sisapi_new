<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah_model extends CI_Model {

	protected $table = 'wilayah';

	public function get_provinsi()
	{
		return $this->db->where('tingkat', 'provinsi')->order_by('nama', 'ASC')->get($this->table)->result();
	}

	public function get_kabupaten($provinsi_id)
	{
		return $this->db->where('tingkat', 'kabupaten')->where('parent_id', $provinsi_id)
			->order_by('nama', 'ASC')->get($this->table)->result();
	}

	public function get_kecamatan($kabupaten_id)
	{
		return $this->db->where('tingkat', 'kecamatan')->where('parent_id', $kabupaten_id)
			->order_by('nama', 'ASC')->get($this->table)->result();
	}

	public function get_desa($kecamatan_id)
	{
		return $this->db->where('tingkat', 'desa')->where('parent_id', $kecamatan_id)
			->order_by('nama', 'ASC')->get($this->table)->result();
	}

	public function get_semua_kabupaten()
	{
		return $this->db->where('tingkat', 'kabupaten')->order_by('nama', 'ASC')->get($this->table)->result();
	}

	public function get_by_id($id)
	{
		return $this->db->where('id', $id)->get($this->table)->row();
	}

	public function create($nama, $tingkat, $parent_id = NULL, $kode = '')
	{
		$this->db->insert($this->table, array(
			'kode' => $kode, 'nama' => $nama, 'tingkat' => $tingkat, 'parent_id' => $parent_id,
		));
		return $this->db->insert_id();
	}
}
