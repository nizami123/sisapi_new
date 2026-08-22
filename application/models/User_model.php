<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	protected $table = 'users';

	public function get_by_username_or_email($identity)
	{
		return $this->db->select('users.*, roles.nama_role')
			->from($this->table)
			->join('roles', 'roles.id = users.role_id')
			->group_start()
				->where('users.username', $identity)
				->or_where('users.email', $identity)
			->group_end()
			->get()->row();
	}

	public function get_by_id($id)
	{
		return $this->db->select('users.*, roles.nama_role')
			->from($this->table)
			->join('roles', 'roles.id = users.role_id')
			->where('users.id', $id)
			->get()->row();
	}

	public function create_user($data)
	{
		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function verify_password($hashed, $plain)
	{
		return password_verify($plain, $hashed);
	}

	public function update_last_login($id)
	{
		$this->db->where('id', $id)->update($this->table, array('last_login' => date('Y-m-d H:i:s')));
	}

	public function username_or_email_exists($username, $email)
	{
		return $this->db->where('username', $username)->or_where('email', $email)->get($this->table)->num_rows() > 0;
	}

	public function count_by_role($nama_role)
	{
		return $this->db->select('users.id')
			->from($this->table)
			->join('roles', 'roles.id = users.role_id')
			->where('roles.nama_role', $nama_role)
			->count_all_results();
	}
}
