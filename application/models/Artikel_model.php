<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel_model extends CI_Model {

	protected $table = 'artikel';

	public function list_terbit($kategori = NULL, $limit = 6, $offset = 0)
	{
		$this->db->where('status', 'terbit');
		if ($kategori) $this->db->where('kategori_artikel', $kategori);
		return $this->db->order_by('tanggal_terbit', 'DESC')->limit($limit, $offset)->get($this->table)->result();
	}

	public function get_by_slug($slug)
	{
		return $this->db->where('slug', $slug)->where('status', 'terbit')->get($this->table)->row();
	}

	public function tambah_view($id)
	{
		$this->db->set('jumlah_dilihat', 'jumlah_dilihat + 1', FALSE)->where('id', $id)->update($this->table);
	}

	public function create($data)
	{
		$data['slug'] = url_title(strtolower($data['judul']), '-', TRUE) . '-' . substr(uniqid(), -5);
		$data['created_at'] = date('Y-m-d H:i:s');
		if ($data['status'] === 'terbit') $data['tanggal_terbit'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		return $this->db->where('id', $id)->update($this->table, $data);
	}

	public function delete($id)
	{
		return $this->db->where('id', $id)->delete($this->table);
	}

	public function get_all_admin($limit = 20, $offset = 0)
	{
		return $this->db->order_by('created_at', 'DESC')->limit($limit, $offset)->get($this->table)->result();
	}
}
