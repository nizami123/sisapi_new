<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model
{
    protected $table = 'products';

    /**
     * Base select yang menggabungkan produk + penjual + kategori + foto utama.
     */
    protected function base_select()
    {
        $this->db->select("
            products.*,
            seller_profiles.farm_name, seller_profiles.is_verified, seller_profiles.rating_avg,
            seller_profiles.id as seller_profile_id,
            users.name as seller_name, users.phone_whatsapp,
            categories.name as category_name, categories.slug as category_slug, categories.icon as category_icon,
            regencies.name as regency_name, districts.name as district_name,
            (SELECT image_path FROM product_images WHERE product_images.product_id = products.id ORDER BY is_primary DESC, sort_order ASC LIMIT 1) as main_image
        ");
        $this->db->from($this->table);
        $this->db->join('seller_profiles', 'seller_profiles.id = products.seller_id');
        $this->db->join('users', 'users.id = seller_profiles.user_id');
        $this->db->join('categories', 'categories.id = products.category_id');
        $this->db->join('regencies', 'regencies.id = products.regency_id', 'left');
        $this->db->join('districts', 'districts.id = products.district_id', 'left');
        return $this;
    }

    /**
     * Listing dengan filter dinamis. $filters bisa berisi:
     * category_id, regency_id, district_id, min_price, max_price, keyword,
     * sort (terbaru|terdekat|harga_asc|harga_desc), user_lat, user_lng
     */
    public function get_listing($filters = array(), $limit = 12, $offset = 0)
    {
        $this->base_select();
        $this->db->where('products.status', 'active');

        if (!empty($filters['category_id'])) {
            $this->db->where('products.category_id', $filters['category_id']);
        }
        if (!empty($filters['regency_id'])) {
            $this->db->where('products.regency_id', $filters['regency_id']);
        }
        if (!empty($filters['district_id'])) {
            $this->db->where('products.district_id', $filters['district_id']);
        }
        if (!empty($filters['min_price'])) {
            $this->db->where('products.price >=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $this->db->where('products.price <=', $filters['max_price']);
        }
        if (!empty($filters['keyword'])) {
            $this->db->group_start();
            $this->db->like('products.name', $filters['keyword']);
            $this->db->or_like('categories.name', $filters['keyword']);
            $this->db->group_end();
        }

        $sort = isset($filters['sort']) ? $filters['sort'] : 'terbaru';
        switch ($sort) {
            case 'harga_asc':
                $this->db->order_by('products.price', 'ASC');
                break;
            case 'harga_desc':
                $this->db->order_by('products.price', 'DESC');
                break;
            case 'terdekat':
                // jarak dihitung & diurutkan di PHP setelah query (lihat get_listing_with_distance)
                $this->db->order_by('products.created_at', 'DESC');
                break;
            default:
                $this->db->order_by('products.created_at', 'DESC');
        }

        $this->db->limit($limit, $offset);
        $rows = $this->db->get()->result_array();

        if (!empty($filters['user_lat']) && !empty($filters['user_lng'])) {
            foreach ($rows as &$row) {
                $row['distance_km'] = haversine_distance_km(
                    $filters['user_lat'], $filters['user_lng'],
                    $row['latitude'], $row['longitude']
                );
            }
            unset($row);
            if ($sort === 'terdekat') {
                usort($rows, function ($a, $b) {
                    if ($a['distance_km'] === NULL) return 1;
                    if ($b['distance_km'] === NULL) return -1;
                    return $a['distance_km'] <=> $b['distance_km'];
                });
            }
        }

        return $rows;
    }

    public function count_listing($filters = array())
    {
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = products.category_id');
        $this->db->where('products.status', 'active');

        if (!empty($filters['category_id'])) $this->db->where('products.category_id', $filters['category_id']);
        if (!empty($filters['regency_id'])) $this->db->where('products.regency_id', $filters['regency_id']);
        if (!empty($filters['district_id'])) $this->db->where('products.district_id', $filters['district_id']);
        if (!empty($filters['min_price'])) $this->db->where('products.price >=', $filters['min_price']);
        if (!empty($filters['max_price'])) $this->db->where('products.price <=', $filters['max_price']);
        if (!empty($filters['keyword'])) {
            $this->db->group_start();
            $this->db->like('products.name', $filters['keyword']);
            $this->db->or_like('categories.name', $filters['keyword']);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    public function find_by_slug($slug)
    {
        $this->base_select();
        $this->db->where('products.slug', $slug);
        return $this->db->get()->row_array();
    }

    public function find($id)
    {
        $this->base_select();
        $this->db->where('products.id', $id);
        return $this->db->get()->row_array();
    }

    public function images($product_id)
    {
        return $this->db->where('product_id', $product_id)->order_by('is_primary', 'DESC')->order_by('sort_order', 'ASC')->get('product_images')->result_array();
    }

    public function livestock_detail($product_id)
    {
        return $this->db->where('product_id', $product_id)->get('livestock_details')->row_array();
    }

    public function newest($limit = 8)
    {
        $this->base_select();
        $this->db->where('products.status', 'active');
        $this->db->order_by('products.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function nearby($lat, $lng, $limit = 8)
    {
        $this->base_select();
        $this->db->where('products.status', 'active');
        $rows = $this->db->get()->result_array();
        foreach ($rows as &$row) {
            $row['distance_km'] = haversine_distance_km($lat, $lng, $row['latitude'], $row['longitude']);
        }
        unset($row);
        usort($rows, function ($a, $b) {
            if ($a['distance_km'] === NULL) return 1;
            if ($b['distance_km'] === NULL) return -1;
            return $a['distance_km'] <=> $b['distance_km'];
        });
        return array_slice($rows, 0, $limit);
    }

    public function by_seller($seller_id)
    {
        $this->base_select();
        $this->db->where('products.seller_id', $seller_id);
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function pending_moderation()
    {
        $this->base_select();
        $this->db->where('products.status', 'pending');
        $this->db->order_by('products.created_at', 'ASC');
        return $this->db->get()->result_array();
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

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    public function add_image($product_id, $path, $is_primary = 0, $sort = 0)
    {
        return $this->db->insert('product_images', array(
            'product_id' => $product_id,
            'image_path' => $path,
            'is_primary' => $is_primary,
            'sort_order' => $sort
        ));
    }

    public function save_livestock_detail($product_id, $data)
    {
        $data['product_id'] = $product_id;
        $existing = $this->db->where('product_id', $product_id)->get('livestock_details')->row_array();
        if ($existing) {
            return $this->db->where('product_id', $product_id)->update('livestock_details', $data);
        }
        return $this->db->insert('livestock_details', $data);
    }

    // ---------------- STATISTIK ----------------

    public function record_view($product_id)
    {
        $this->db->insert('product_views', array(
            'product_id' => $product_id,
            'ip_address' => $this->ci_input_ip(),
            'viewed_at' => date('Y-m-d H:i:s')
        ));
        $this->db->set('view_count', 'view_count + 1', FALSE)->where('id', $product_id)->update($this->table);
    }

    public function record_whatsapp_click($product_id)
    {
        $this->db->insert('whatsapp_clicks', array(
            'product_id' => $product_id,
            'ip_address' => $this->ci_input_ip(),
            'clicked_at' => date('Y-m-d H:i:s')
        ));
        $this->db->set('whatsapp_click_count', 'whatsapp_click_count + 1', FALSE)->where('id', $product_id)->update($this->table);
    }

    protected function ci_input_ip()
    {
        $ci =& get_instance();
        return $ci->input->ip_address();
    }

    public function count_by_status($status)
    {
        return $this->db->where('status', $status)->count_all_results($this->table);
    }

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function most_viewed($limit = 5)
    {
        $this->base_select();
        $this->db->order_by('products.view_count', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function most_whatsapp_clicked($limit = 5)
    {
        $this->base_select();
        $this->db->order_by('products.whatsapp_click_count', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function sum_whatsapp_clicks()
    {
        $row = $this->db->select_sum('whatsapp_click_count')->get($this->table)->row_array();
        return $row['whatsapp_click_count'] ? $row['whatsapp_click_count'] : 0;
    }
}
