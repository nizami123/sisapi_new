<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model {

	protected $table = 'kategori';

	public function get_all_active()
	{
		return $this->db->where('status', 1)->order_by('urutan', 'ASC')->get($this->table)->result();
	}

	public function get_all()
	{
		return $this->db->order_by('urutan', 'ASC')->get($this->table)->result();
	}

	public function get_by_slug($slug)
	{
		return $this->db->where('slug', $slug)->get($this->table)->row();
	}

	public function get_by_id($id)
	{
		return $this->db->where('id', $id)->get($this->table)->row();
	}

	public function create($data)
	{
		$data['slug'] = url_title(strtolower($data['nama_kategori']), '-', TRUE);
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

	public function count_produk_per_kategori()
	{
		return $this->db->select('kategori.nama_kategori, COUNT(produk.id) AS total')
			->from($this->table)
			->join('produk', 'produk.kategori_id = kategori.id AND produk.status_verifikasi = "disetujui"', 'left')
			->group_by('kategori.id')
			->order_by('total', 'DESC')
			->get()->result();
	}
}
