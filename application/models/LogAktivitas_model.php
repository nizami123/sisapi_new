<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LogAktivitas_model extends CI_Model {

	protected $table = 'log_aktivitas';

	public function list_log($filters = array(), $limit = 50, $offset = 0)
	{
		$this->db->select('log_aktivitas.*, users.username')
			->from($this->table)
			->join('users', 'users.id = log_aktivitas.user_id', 'left');
		if ( ! empty($filters['modul'])) $this->db->where('log_aktivitas.modul', $filters['modul']);
		if ( ! empty($filters['user_id'])) $this->db->where('log_aktivitas.user_id', $filters['user_id']);
		return $this->db->order_by('log_aktivitas.created_at', 'DESC')->limit($limit, $offset)->get()->result();
	}

	public function count_log($filters = array())
	{
		if ( ! empty($filters['modul'])) $this->db->where('modul', $filters['modul']);
		return $this->db->count_all_results($this->table);
	}
}
