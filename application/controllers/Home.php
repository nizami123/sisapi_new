<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Category_model');
        $this->load->model('Seller_model');
        $this->load->model('Region_model');
    }

    public function index()
    {
        $lat = $this->input->get('lat');
        $lng = $this->input->get('lng');

        $data['categories'] = $this->Category_model->all_active();
        $data['newest_products'] = $this->Product_model->newest(8);
        $data['verified_sellers'] = $this->Seller_model->verified_list(4);

        if ($lat && $lng) {
            $data['nearby_products'] = $this->Product_model->nearby($lat, $lng, 4);
        } else {
            $data['nearby_products'] = array();
        }

        $data['title'] = 'SISAPI - Pasar Ternak & Produk Peternakan Digital';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('frontend/home', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Halaman listing / pencarian dengan filter (kategori, wilayah, harga, urutan).
     */
    public function search()
    {
        $filters = array(
            'keyword'     => $this->input->get('q'),
            'category_id' => $this->input->get('category_id'),
            'regency_id'  => $this->input->get('regency_id'),
            'district_id' => $this->input->get('district_id'),
            'min_price'   => $this->input->get('min_price'),
            'max_price'   => $this->input->get('max_price'),
            'sort'        => $this->input->get('sort') ?: 'terbaru',
            'user_lat'    => $this->input->get('lat'),
            'user_lng'    => $this->input->get('lng'),
        );

        $per_page = 12;
        $page = (int) ($this->input->get('page') ?: 1);
        $offset = ($page - 1) * $per_page;

        $data['products'] = $this->Product_model->get_listing($filters, $per_page, $offset);
        $data['total_products'] = $this->Product_model->count_listing($filters);
        $data['total_pages'] = ceil($data['total_products'] / $per_page);
        $data['current_page'] = $page;

        $data['categories'] = $this->Category_model->all_active();
        $data['regencies'] = $this->Region_model->regencies(1); // default; diisi ulang via AJAX di JS
        $data['filters'] = $filters;
        $data['title'] = 'Cari Ternak & Produk Peternakan - SISAPI';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('frontend/product_list', $data);
        $this->load->view('templates/footer', $data);
    }

    public function category($slug)
    {
        $category = $this->Category_model->find_by_slug($slug);
        if (!$category) show_404();

        $_GET['category_id'] = $category['id'];
        $this->search();
    }

    public function nearby()
    {
        $data['categories'] = $this->Category_model->all_active();
        $data['title'] = 'Ternak di Sekitar Saya - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('frontend/nearby', $data);
        $this->load->view('templates/footer', $data);
    }

    public function sellers()
    {
        $data['sellers'] = $this->Seller_model->verified_list(50);
        $data['title'] = 'Peternak Terverifikasi - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('frontend/sellers', $data);
        $this->load->view('templates/footer', $data);
    }

    public function seller_profile($id)
    {
        $seller = $this->Seller_model->find($id);
        if (!$seller) show_404();
        $data['seller'] = $seller;
        $data['products'] = $this->Product_model->by_seller($id);
        $data['title'] = $seller['farm_name'] . ' - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('frontend/seller_profile', $data);
        $this->load->view('templates/footer', $data);
    }

    public function about()
    {
        $data['title'] = 'Tentang SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('frontend/about', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Endpoint AJAX: dropdown wilayah bertingkat.
     */
    public function ajax_regencies($province_id)
    {
        echo json_encode($this->Region_model->regencies($province_id));
    }

    public function ajax_districts($regency_id)
    {
        echo json_encode($this->Region_model->districts($regency_id));
    }

    public function ajax_villages($district_id)
    {
        echo json_encode($this->Region_model->villages($district_id));
    }
}
