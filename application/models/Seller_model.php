<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller_model extends CI_Model
{
    protected $table = 'seller_profiles';

    public function find($id)
    {
        return $this->db->select('seller_profiles.*, users.name, users.email, users.phone_whatsapp, users.photo, users.status as user_status')
            ->join('users', 'users.id = seller_profiles.user_id')
            ->where('seller_profiles.id', $id)
            ->get($this->table)->row_array();
    }

    public function find_by_user($user_id)
    {
        return $this->db->where('user_id', $user_id)->get($this->table)->row_array();
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

    public function verified_list($limit = 8)
    {
        return $this->db->select('seller_profiles.*, users.name, users.photo')
            ->join('users', 'users.id = seller_profiles.user_id')
            ->where('seller_profiles.is_verified', 1)
            ->order_by('seller_profiles.rating_avg', 'DESC')
            ->limit($limit)
            ->get($this->table)->result_array();
    }

    public function pending_verification()
    {
        return $this->db->select('seller_profiles.*, users.name, users.email, users.phone_whatsapp, users.photo')
            ->join('users', 'users.id = seller_profiles.user_id')
            ->where('seller_profiles.is_verified', 0)
            ->order_by('seller_profiles.created_at', 'ASC')
            ->get($this->table)->result_array();
    }

    public function verify($id, $admin_id)
    {
        return $this->db->where('id', $id)->update($this->table, array(
            'is_verified' => 1,
            'verified_at' => date('Y-m-d H:i:s'),
            'verified_by' => $admin_id
        ));
    }

    public function reject($id, $reason)
    {
        return $this->db->where('id', $id)->update($this->table, array(
            'is_verified' => 0,
            'rejection_reason' => $reason
        ));
    }

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }
}
