<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model {

	protected $table = 'produk';

	/**
	 * Query listing produk publik (hanya yang sudah disetujui & aktif)
	 * $filters bisa berisi: kategori, kabupaten_id, kecamatan_id, harga_min, harga_max,
	 *                       jenis_kelamin, bobot_min, bobot_max, umur_min, umur_max, q (keyword)
	 * $sort: terbaru | termurah | termahal | terpopuler
	 */
	public function get_listing($filters = array(), $sort = 'terbaru', $limit = 12, $offset = 0)
	{
		$this->_apply_filters($filters);
		$this->db->where('produk.status_verifikasi', 'disetujui')->where('produk.status_aktif', 1);

		switch ($sort) {
			case 'termurah':   $this->db->order_by('produk.harga', 'ASC'); break;
			case 'termahal':   $this->db->order_by('produk.harga', 'DESC'); break;
			case 'terpopuler': $this->db->order_by('produk.jumlah_dilihat', 'DESC'); break;
			default:           $this->db->order_by('produk.created_at', 'DESC'); break;
		}

		return $this->db->select('produk.*, kategori.nama_kategori, peternak.nama_lengkap AS nama_peternak')
			->from($this->table)
			->join('kategori', 'kategori.id = produk.kategori_id')
			->join('peternak', 'peternak.id = produk.peternak_id')
			->limit($limit, $offset)
			->get()->result();
	}

	public function count_listing($filters = array())
	{
		$this->_apply_filters($filters);
		return $this->db->where('status_verifikasi', 'disetujui')->where('status_aktif', 1)
			->count_all_results($this->table);
	}

	private function _apply_filters($filters)
	{
		if ( ! empty($filters['kategori_id']))   $this->db->where('produk.kategori_id', $filters['kategori_id']);
		if ( ! empty($filters['kabupaten_id']))  $this->db->where('produk.kabupaten_id', $filters['kabupaten_id']);
		if ( ! empty($filters['kecamatan_id']))  $this->db->where('produk.kecamatan_id', $filters['kecamatan_id']);
		if ( ! empty($filters['jenis_kelamin'])) $this->db->where('produk.jenis_kelamin', $filters['jenis_kelamin']);
		if ( ! empty($filters['harga_min']))     $this->db->where('produk.harga >=', $filters['harga_min']);
		if ( ! empty($filters['harga_max']))     $this->db->where('produk.harga <=', $filters['harga_max']);
		if ( ! empty($filters['bobot_min']))     $this->db->where('produk.bobot_kg >=', $filters['bobot_min']);
		if ( ! empty($filters['bobot_max']))     $this->db->where('produk.bobot_kg <=', $filters['bobot_max']);
		if ( ! empty($filters['umur_max']))      $this->db->where('produk.umur_tahun <=', $filters['umur_max']);
		if ( ! empty($filters['q'])) {
			$this->db->group_start()
				->like('produk.nama_ternak', $filters['q'])
				->or_like('produk.ras', $filters['q'])
				->or_like('produk.deskripsi', $filters['q'])
			->group_end();
		}
	}

	public function get_by_slug($slug)
	{
		return $this->db->select('produk.*, kategori.nama_kategori, kategori.slug AS kategori_slug,
				peternak.nama_lengkap AS nama_peternak, peternak.status_verifikasi AS peternak_verified,
				users.foto_profil AS foto_peternak, users.id AS peternak_user_id')
			->from($this->table)
			->join('kategori', 'kategori.id = produk.kategori_id')
			->join('peternak', 'peternak.id = produk.peternak_id')
			->join('users', 'users.id = peternak.user_id')
			->where('produk.slug', $slug)
			->get()->row();
	}

	public function get_galeri($produk_id)
	{
		return $this->db->where('produk_id', $produk_id)->order_by('urutan', 'ASC')->get('foto_produk')->result();
	}

	public function tambah_view($produk_id)
	{
		$this->db->set('jumlah_dilihat', 'jumlah_dilihat + 1', FALSE)->where('id', $produk_id)->update($this->table);
	}

	public function tambah_klik_wa($produk_id)
	{
		$this->db->set('jumlah_klik_wa', 'jumlah_klik_wa + 1', FALSE)->where('id', $produk_id)->update($this->table);
	}

	public function terbaru($limit = 8)
	{
		return $this->get_listing(array(), 'terbaru', $limit, 0);
	}

	public function terpopuler($limit = 8)
	{
		return $this->get_listing(array(), 'terpopuler', $limit, 0);
	}

	public function create($data)
	{
		$data['slug'] = buat_slug($data['nama_ternak']);
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		return $this->db->where('id', $id)->update($this->table, $data);
	}

	public function get_by_peternak($peternak_id)
	{
		return $this->db->select('produk.*, kategori.nama_kategori')
			->from($this->table)->join('kategori', 'kategori.id = produk.kategori_id')
			->where('produk.peternak_id', $peternak_id)
			->order_by('produk.created_at', 'DESC')->get()->result();
	}

	public function list_for_admin($status = NULL, $limit = 20, $offset = 0)
	{
		$this->db->select('produk.*, kategori.nama_kategori, peternak.nama_lengkap AS nama_peternak')
			->from($this->table)
			->join('kategori', 'kategori.id = produk.kategori_id')
			->join('peternak', 'peternak.id = produk.peternak_id');
		if ($status) $this->db->where('produk.status_verifikasi', $status);
		return $this->db->order_by('produk.created_at', 'DESC')->limit($limit, $offset)->get()->result();
	}

	public function count_by_status($status = NULL)
	{
		if ($status) $this->db->where('status_verifikasi', $status);
		return $this->db->count_all_results($this->table);
	}

	public function set_status($id, $status, $catatan, $admin_id)
	{
		$update = array(
			'status_verifikasi'  => $status,
			'catatan_verifikasi' => $catatan,
			'verified_by'        => $admin_id,
		);
		if ($status === 'disetujui') $update['tanggal_approve'] = date('Y-m-d H:i:s');
		$this->update($id, $update);

		$this->db->insert('approval_produk', array(
			'produk_id' => $id,
			'admin_id'  => $admin_id,
			'aksi'      => $status === 'disetujui' ? 'approve' : 'reject',
			'catatan'   => $catatan,
			'created_at'=> date('Y-m-d H:i:s'),
		));
	}

	public function autocomplete($keyword, $limit = 10)
	{
		return $this->db->select('id, nama_ternak, slug')
			->like('nama_ternak', $keyword)
			->where('status_verifikasi', 'disetujui')
			->limit($limit)->get($this->table)->result();
	}
}
