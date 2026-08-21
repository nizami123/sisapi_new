<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{
    protected $table = 'categories';

    public function all_active()
    {
        return $this->db->where('is_active', 1)->order_by('sort_order', 'ASC')->get($this->table)->result_array();
    }

    public function all()
    {
        return $this->db->order_by('sort_order', 'ASC')->get($this->table)->result_array();
    }

    public function find($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    public function find_by_slug($slug)
    {
        return $this->db->where('slug', $slug)->get($this->table)->row_array();
    }

    public function create($data)
    {
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
