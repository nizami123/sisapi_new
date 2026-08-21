<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('make_slug')) {
    function make_slug($string)
    {
        $string = strtolower(trim($string));
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        return trim($string, '-');
    }
}

/**
 * Pastikan slug unik pada tabel 'products' dengan menambahkan angka increment bila perlu.
 * $CI wajib sudah punya $this->db aktif.
 */
if (!function_exists('unique_product_slug')) {
    function unique_product_slug($CI, $base_name, $exclude_id = NULL)
    {
        $slug = make_slug($base_name);
        $original = $slug;
        $i = 1;
        while (true) {
            $CI->db->where('slug', $slug);
            if ($exclude_id) {
                $CI->db->where('id !=', $exclude_id);
            }
            $exists = $CI->db->get('products')->num_rows();
            if ($exists == 0) break;
            $i++;
            $slug = $original . '-' . $i;
        }
        return $slug;
    }
}
