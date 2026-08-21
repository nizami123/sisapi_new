<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Controller.php';

class Admin extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Seller_model');
        $this->load->model('Category_model');
        $this->load->model('User_model');
    }

    public function dashboard()
    {
        $data['total_users'] = $this->db->count_all('users');
        $data['total_sellers'] = $this->User_model->count_by_role('seller');
        $data['total_buyers'] = $this->User_model->count_by_role('buyer');
        $data['total_listing'] = $this->Product_model->count_all();
        $data['total_active'] = $this->Product_model->count_by_status('active');
        $data['total_sold'] = $this->Product_model->count_by_status('sold');
        $data['total_pending'] = $this->Product_model->count_by_status('pending');
        $data['total_whatsapp_clicks'] = $this->Product_model->sum_whatsapp_clicks();
        $data['most_viewed'] = $this->Product_model->most_viewed(5);
        $data['most_clicked'] = $this->Product_model->most_whatsapp_clicked(5);
        $data['pending_sellers_count'] = count($this->Seller_model->pending_verification());

        $data['title'] = 'Dashboard Admin - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer', $data);
    }

    public function users()
    {
        $data['users'] = $this->db->order_by('created_at', 'DESC')->get('users')->result_array();
        $data['title'] = 'Kelola Pengguna - SISAPI Admin';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('templates/footer', $data);
    }

    public function suspend_user($id)
    {
        $this->User_model->update($id, array('status' => 'suspended'));
        $this->session->set_flashdata('success', 'Pengguna dinonaktifkan.');
        redirect('admin/pengguna');
    }

    public function activate_user($id)
    {
        $this->User_model->update($id, array('status' => 'active'));
        $this->session->set_flashdata('success', 'Pengguna diaktifkan kembali.');
        redirect('admin/pengguna');
    }

    public function sellers()
    {
        $data['sellers'] = $this->db->select('seller_profiles.*, users.name, users.email, users.phone_whatsapp, users.status as user_status')
            ->join('users', 'users.id = seller_profiles.user_id')
            ->order_by('seller_profiles.created_at', 'DESC')
            ->get('seller_profiles')->result_array();
        $data['title'] = 'Kelola Peternak - SISAPI Admin';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/sellers', $data);
        $this->load->view('templates/footer', $data);
    }

    public function verify_sellers()
    {
        if ($this->input->method() === 'post') {
            $seller_id = $this->input->post('seller_id');
            $action = $this->input->post('action');

            if ($action === 'verify') {
                $this->Seller_model->verify($seller_id, $this->current_user['id']);
                $this->session->set_flashdata('success', 'Peternak berhasil diverifikasi.');
            } elseif ($action === 'reject') {
                $this->Seller_model->reject($seller_id, $this->input->post('reason', TRUE));
                $this->session->set_flashdata('success', 'Pendaftaran peternak ditolak.');
            }
            redirect('admin/verifikasi-peternak');
            return;
        }

        $data['pending'] = $this->Seller_model->pending_verification();
        $data['title'] = 'Verifikasi Peternak - SISAPI Admin';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/verify_sellers', $data);
        $this->load->view('templates/footer', $data);
    }

    public function categories()
    {
        if ($this->input->method() === 'post') {
            $action = $this->input->post('action');
            if ($action === 'add') {
                $this->Category_model->create(array(
                    'name' => $this->input->post('name', TRUE),
                    'slug' => make_slug($this->input->post('name', TRUE)),
                    'icon' => $this->input->post('icon', TRUE) ?: 'fa-paw',
                    'type' => $this->input->post('type'),
                    'is_active' => 1,
                    'sort_order' => (int) $this->input->post('sort_order')
                ));
                $this->session->set_flashdata('success', 'Kategori ditambahkan.');
            } elseif ($action === 'toggle') {
                $cat = $this->Category_model->find($this->input->post('category_id'));
                $this->Category_model->update($cat['id'], array('is_active' => $cat['is_active'] ? 0 : 1));
                $this->session->set_flashdata('success', 'Status kategori diperbarui.');
            } elseif ($action === 'delete') {
                $this->Category_model->delete($this->input->post('category_id'));
                $this->session->set_flashdata('success', 'Kategori dihapus.');
            }
            redirect('admin/kategori');
            return;
        }

        $data['categories'] = $this->Category_model->all();
        $data['title'] = 'Kelola Kategori - SISAPI Admin';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/categories', $data);
        $this->load->view('templates/footer', $data);
    }

    public function listings()
    {
        $status = $this->input->get('status');
        $this->db->select('products.*, users.name as seller_name, categories.name as category_name')
            ->from('products')
            ->join('seller_profiles', 'seller_profiles.id = products.seller_id')
            ->join('users', 'users.id = seller_profiles.user_id')
            ->join('categories', 'categories.id = products.category_id')
            ->order_by('products.created_at', 'DESC');
        if ($status) $this->db->where('products.status', $status);
        $data['listings'] = $this->db->get()->result_array();

        $data['title'] = 'Kelola Listing - SISAPI Admin';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/listings', $data);
        $this->load->view('templates/footer', $data);
    }

    public function moderation()
    {
        if ($this->input->method() === 'post') {
            $product_id = $this->input->post('product_id');
            $action = $this->input->post('action');

            if ($action === 'approve') {
                $this->Product_model->update($product_id, array('status' => 'active'));
                $this->session->set_flashdata('success', 'Listing disetujui dan tayang di SISAPI.');
            } elseif ($action === 'reject') {
                $this->Product_model->update($product_id, array(
                    'status' => 'rejected',
                    'rejection_reason' => $this->input->post('reason', TRUE)
                ));
                $this->session->set_flashdata('success', 'Listing ditolak.');
            }
            redirect('admin/moderasi');
            return;
        }

        $data['pending_products'] = $this->Product_model->pending_moderation();
        $data['title'] = 'Moderasi Listing - SISAPI Admin';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/moderation', $data);
        $this->load->view('templates/footer', $data);
    }

    public function reports()
    {
        $data['reports'] = $this->db->select('product_reports.*, products.name as product_name, products.slug')
            ->join('products', 'products.id = product_reports.product_id')
            ->order_by('product_reports.created_at', 'DESC')
            ->get('product_reports')->result_array();
        $data['title'] = 'Laporan Listing - SISAPI Admin';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/reports', $data);
        $this->load->view('templates/footer', $data);
    }

    public function regions()
    {
        $data['provinces'] = $this->db->order_by('name')->get('provinces')->result_array();
        $data['title'] = 'Kelola Wilayah - SISAPI Admin';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/regions', $data);
        $this->load->view('templates/footer', $data);
    }
}
