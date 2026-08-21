<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Region_model extends CI_Model
{
    public function provinces()
    {
        return $this->db->order_by('name', 'ASC')->get('provinces')->result_array();
    }

    public function regencies($province_id)
    {
        return $this->db->where('province_id', $province_id)->order_by('name', 'ASC')->get('regencies')->result_array();
    }

    public function districts($regency_id)
    {
        return $this->db->where('regency_id', $regency_id)->order_by('name', 'ASC')->get('districts')->result_array();
    }

    public function villages($district_id)
    {
        return $this->db->where('district_id', $district_id)->order_by('name', 'ASC')->get('villages')->result_array();
    }

    public function regency_name($id)
    {
        $row = $this->db->where('id', $id)->get('regencies')->row_array();
        return $row ? $row['name'] : '';
    }

    public function district_name($id)
    {
        $row = $this->db->where('id', $id)->get('districts')->row_array();
        return $row ? $row['name'] : '';
    }
}
