<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Favorite_model extends CI_Model
{
    public function toggle($user_id, $product_id)
    {
        $existing = $this->db->where(array('user_id' => $user_id, 'product_id' => $product_id))->get('favorites')->row_array();
        if ($existing) {
            $this->db->where('id', $existing['id'])->delete('favorites');
            return FALSE; // sekarang tidak favorit
        }
        $this->db->insert('favorites', array(
            'user_id' => $user_id,
            'product_id' => $product_id,
            'created_at' => date('Y-m-d H:i:s')
        ));
        return TRUE; // sekarang favorit
    }

    public function is_favorited($user_id, $product_id)
    {
        return (bool) $this->db->where(array('user_id' => $user_id, 'product_id' => $product_id))->get('favorites')->row_array();
    }

    public function user_favorites($user_id)
    {
        return $this->db->select('products.*')
            ->join('products', 'products.id = favorites.product_id')
            ->where('favorites.user_id', $user_id)
            ->get('favorites')->result_array();
    }
}
