<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peternak_model extends CI_Model {

	protected $table = 'peternak';

	public function get_by_user_id($user_id)
	{
		return $this->db->where('user_id', $user_id)->get($this->table)->row();
	}

	public function get_by_id($id)
	{
		return $this->db->select('peternak.*, users.email, users.username, users.foto_profil, users.nomor_hp')
			->from($this->table)
			->join('users', 'users.id = peternak.user_id')
			->where('peternak.id', $id)
			->get()->row();
	}

	public function create($data)
	{
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		return $this->db->where('id', $id)->update($this->table, $data);
	}

	/**
	 * Daftar peternak dengan filter status verifikasi (untuk admin)
	 */
	public function list_peternak($status = NULL, $limit = 20, $offset = 0)
	{
		$this->db->select('peternak.*, users.email, users.username')
			->from($this->table)
			->join('users', 'users.id = peternak.user_id');
		if ($status) {
			$this->db->where('peternak.status_verifikasi', $status);
		}
		return $this->db->order_by('peternak.created_at', 'DESC')->limit($limit, $offset)->get()->result();
	}

	public function count_by_status($status = NULL)
	{
		if ($status) $this->db->where('status_verifikasi', $status);
		return $this->db->count_all_results($this->table);
	}

	/**
	 * Peternak terpercaya = sudah diverifikasi, diurutkan rating & jumlah produk terjual/dilihat
	 */
	public function peternak_terpercaya($limit = 8)
	{
		return $this->db->select('peternak.*, users.foto_profil')
			->from($this->table)
			->join('users', 'users.id = peternak.user_id')
			->where('peternak.status_verifikasi', 'disetujui')
			->order_by('peternak.rating_rata', 'DESC')
			->limit($limit)
			->get()->result();
	}

	public function set_status($id, $status, $catatan, $admin_id)
	{
		$this->update($id, array(
			'status_verifikasi'  => $status,
			'catatan_verifikasi' => $catatan,
			'verified_by'        => $admin_id,
			'verified_at'        => date('Y-m-d H:i:s'),
		));

		$this->db->insert('approval_peternak', array(
			'peternak_id' => $id,
			'admin_id'    => $admin_id,
			'aksi'        => $status === 'disetujui' ? 'approve' : ($status === 'ditolak' ? 'reject' : 'perbaikan'),
			'catatan'     => $catatan,
			'created_at'  => date('Y-m-d H:i:s'),
		));
	}
}
