<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function detail($slug)
    {
        $product = $this->Product_model->find_by_slug($slug);
        if (!$product || $product['status'] === 'draft' || $product['status'] === 'rejected') {
            show_404();
        }

        // Catat view (hanya untuk listing yang sudah aktif/terjual, bukan punya sendiri di preview admin)
        $this->Product_model->record_view($product['id']);

        $data['product'] = $product;
        $data['images'] = $this->Product_model->images($product['id']);
        $data['livestock'] = $this->Product_model->livestock_detail($product['id']);
        $data['whatsapp_link'] = whatsapp_product_link($product['phone_whatsapp'], $product['name']);
        $data['title'] = $product['name'] . ' - SISAPI';
        $data['meta_description'] = $product['meta_description'] ?: mb_strimwidth(strip_tags($product['description']), 0, 160, '...');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('frontend/product_detail', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Dipanggil via AJAX/fetch (navigator.sendBeacon atau fetch keepalive) saat
     * tombol "Hubungi Penjual via WhatsApp" diklik, sebelum window.open ke wa.me.
     */
    public function track_whatsapp_click($product_id)
    {
        $this->Product_model->record_whatsapp_click($product_id);
        echo json_encode(array('status' => 'ok'));
    }

    /**
     * Toggle favorit (butuh login sebagai buyer/seller).
     */
    public function toggle_favorite($product_id)
    {
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            echo json_encode(array('status' => 'need_login'));
            return;
        }
        $this->load->model('Favorite_model');
        $result = $this->Favorite_model->toggle($user_id, $product_id);
        echo json_encode(array('status' => 'ok', 'favorited' => $result));
    }

    /**
     * Form laporkan listing (spam / info salah / sudah terjual tapi masih aktif, dll).
     */
    public function report($product_id)
    {
        $reason = $this->input->post('reason');
        if (!$reason) {
            echo json_encode(array('status' => 'error', 'message' => 'Alasan wajib diisi'));
            return;
        }
        $this->db->insert('product_reports', array(
            'product_id' => $product_id,
            'reporter_name' => $this->input->post('reporter_name'),
            'reason' => $reason,
            'created_at' => date('Y-m-d H:i:s')
        ));
        echo json_encode(array('status' => 'ok'));
    }
}
