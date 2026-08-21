<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Controller.php';

class Seller extends Seller_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Category_model');
        $this->load->model('Region_model');
        $this->load->library('form_validation');
    }

    public function dashboard()
    {
        $seller_id = $this->seller_profile['id'];
        $products = $this->Product_model->by_seller($seller_id);

        $data['seller'] = $this->seller_profile;
        $data['total_active'] = count(array_filter($products, function ($p) { return $p['status'] === 'active'; }));
        $data['total_sold'] = count(array_filter($products, function ($p) { return $p['status'] === 'sold'; }));
        $data['total_products'] = count($products);
        $data['total_views'] = array_sum(array_column($products, 'view_count'));
        $data['total_whatsapp_clicks'] = array_sum(array_column($products, 'whatsapp_click_count'));
        $data['recent_products'] = array_slice($products, 0, 5);

        $data['title'] = 'Dashboard Peternak - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('seller/dashboard', $data);
        $this->load->view('templates/footer', $data);
    }

    public function my_products()
    {
        $data['seller'] = $this->seller_profile;
        $data['products'] = $this->Product_model->by_seller($this->seller_profile['id']);
        $data['title'] = 'Ternak Saya - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('seller/my_products', $data);
        $this->load->view('templates/footer', $data);
    }

    public function add_product()
    {
        if (!$this->seller_profile['is_verified']) {
            $this->session->set_flashdata('warning', 'Akun peternak Anda belum diverifikasi admin. Anda tetap bisa menambah listing, namun akan tampil setelah akun & listing disetujui.');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('category_id', 'Kategori', 'required');
            $this->form_validation->set_rules('name', 'Nama produk', 'required|min_length[5]');
            $this->form_validation->set_rules('price', 'Harga', 'required|numeric');
            $this->form_validation->set_rules('description', 'Deskripsi', 'required');
            $this->form_validation->set_rules('address', 'Alamat', 'required');
            $this->form_validation->set_rules('latitude', 'Titik lokasi', 'required');
            $this->form_validation->set_rules('longitude', 'Titik lokasi', 'required');

            if ($this->form_validation->run()) {
                $slug = unique_product_slug($this, $this->input->post('name', TRUE));

                $category = $this->Category_model->find($this->input->post('category_id'));

                $product_id = $this->Product_model->create(array(
                    'seller_id' => $this->seller_profile['id'],
                    'category_id' => $this->input->post('category_id'),
                    'name' => $this->input->post('name', TRUE),
                    'slug' => $slug,
                    'price' => $this->input->post('price'),
                    'description' => $this->input->post('description', TRUE),
                    'address' => $this->input->post('address', TRUE),
                    'village_id' => $this->input->post('village_id') ?: NULL,
                    'district_id' => $this->input->post('district_id') ?: NULL,
                    'regency_id' => $this->input->post('regency_id') ?: NULL,
                    'province_id' => $this->input->post('province_id') ?: NULL,
                    'latitude' => $this->input->post('latitude'),
                    'longitude' => $this->input->post('longitude'),
                    'status' => 'pending', // wajib moderasi admin
                    'meta_title' => $this->input->post('name', TRUE) . ' - SISAPI',
                    'meta_description' => mb_strimwidth(strip_tags($this->input->post('description', TRUE)), 0, 155, '...'),
                ));

                // Field khusus ternak
                if ($category && $category['type'] === 'livestock') {
                    $this->Product_model->save_livestock_detail($product_id, array(
                        'jenis' => $this->input->post('jenis', TRUE),
                        'ras' => $this->input->post('ras', TRUE),
                        'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                        'umur' => $this->input->post('umur', TRUE),
                        'berat' => $this->input->post('berat', TRUE),
                        'warna' => $this->input->post('warna', TRUE),
                        'kondisi_kesehatan' => $this->input->post('kondisi_kesehatan', TRUE),
                        'status_vaksinasi' => $this->input->post('status_vaksinasi', TRUE),
                    ));
                }

                $this->_handle_photo_uploads($product_id);

                $this->session->set_flashdata('success', 'Listing berhasil ditambahkan dan sedang menunggu moderasi admin.');
                redirect('dashboard/ternak-saya');
                return;
            } else {
                $data['error'] = validation_errors();
            }
        }

        $data['categories'] = $this->Category_model->all_active();
        $data['provinces'] = $this->Region_model->provinces();
        $data['seller'] = $this->seller_profile;
        $data['title'] = 'Tambah Ternak/Produk - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('seller/add_product', $data);
        $this->load->view('templates/footer', $data);
    }

    public function edit_product($id)
    {
        $product = $this->Product_model->find($id);
        if (!$product || $product['seller_profile_id'] != $this->seller_profile['id']) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            // Tandai terjual / nonaktifkan / update status cepat
            if ($this->input->post('action') === 'mark_sold') {
                $this->Product_model->update($id, array('status' => 'sold'));
                $this->session->set_flashdata('success', 'Listing ditandai sebagai Terjual.');
                redirect('dashboard/ternak-saya');
                return;
            }
            if ($this->input->post('action') === 'deactivate') {
                $this->Product_model->update($id, array('status' => 'inactive'));
                $this->session->set_flashdata('success', 'Listing dinonaktifkan.');
                redirect('dashboard/ternak-saya');
                return;
            }
            if ($this->input->post('action') === 'reactivate') {
                $this->Product_model->update($id, array('status' => 'pending'));
                $this->session->set_flashdata('success', 'Listing diaktifkan kembali dan menunggu moderasi admin.');
                redirect('dashboard/ternak-saya');
                return;
            }

            // Update lengkap
            $this->form_validation->set_rules('name', 'Nama produk', 'required|min_length[5]');
            $this->form_validation->set_rules('price', 'Harga', 'required|numeric');
            $this->form_validation->set_rules('description', 'Deskripsi', 'required');

            if ($this->form_validation->run()) {
                $this->Product_model->update($id, array(
                    'name' => $this->input->post('name', TRUE),
                    'price' => $this->input->post('price'),
                    'description' => $this->input->post('description', TRUE),
                    'status' => 'pending', // perubahan wajib dimoderasi ulang
                ));
                $this->_handle_photo_uploads($id);
                $this->session->set_flashdata('success', 'Listing diperbarui dan menunggu moderasi ulang.');
                redirect('dashboard/ternak-saya');
                return;
            } else {
                $data['error'] = validation_errors();
            }
        }

        $data['product'] = $product;
        $data['images'] = $this->Product_model->images($id);
        $data['livestock'] = $this->Product_model->livestock_detail($id);
        $data['categories'] = $this->Category_model->all_active();
        $data['title'] = 'Edit Listing - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('seller/edit_product', $data);
        $this->load->view('templates/footer', $data);
    }

    public function profile()
    {
        if ($this->input->method() === 'post') {
            $this->Seller_model->update($this->seller_profile['id'], array(
                'farm_name' => $this->input->post('farm_name', TRUE),
                'description' => $this->input->post('description', TRUE),
            ));
            $this->User_model->update($this->current_user['id'], array(
                'name' => $this->input->post('name', TRUE),
                'phone_whatsapp' => $this->input->post('phone_whatsapp', TRUE),
            ));
            $this->session->set_flashdata('success', 'Profil peternakan diperbarui.');
            redirect('dashboard/profil');
            return;
        }

        $data['seller'] = $this->seller_profile;
        $data['user'] = $this->current_user;
        $data['title'] = 'Profil Peternakan - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('seller/profile', $data);
        $this->load->view('templates/footer', $data);
    }

    public function location()
    {
        if ($this->input->method() === 'post') {
            $this->Seller_model->update($this->seller_profile['id'], array(
                'address' => $this->input->post('address', TRUE),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'village_id' => $this->input->post('village_id') ?: NULL,
                'district_id' => $this->input->post('district_id') ?: NULL,
                'regency_id' => $this->input->post('regency_id') ?: NULL,
                'province_id' => $this->input->post('province_id') ?: NULL,
            ));
            $this->session->set_flashdata('success', 'Lokasi peternakan diperbarui.');
            redirect('dashboard/lokasi');
            return;
        }

        $data['seller'] = $this->seller_profile;
        $data['provinces'] = $this->Region_model->provinces();
        $data['title'] = 'Lokasi Peternakan - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('seller/location', $data);
        $this->load->view('templates/footer', $data);
    }

    protected function _handle_photo_uploads($product_id)
    {
        if (empty($_FILES['photos']['name'][0])) return;

        $config['upload_path'] = './uploads/products/';
        $config['allowed_types'] = $this->config->item('sisapi_allowed_image_types');
        $config['max_size'] = $this->config->item('sisapi_upload_max_size');
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        $existing_count = count($this->Product_model->images($product_id));

        $files = $_FILES['photos'];
        for ($i = 0; $i < count($files['name']); $i++) {
            if (empty($files['name'][$i])) continue;
            $_FILES['photo_single'] = array(
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i],
            );
            $this->upload->initialize($config);
            if ($this->upload->do_upload('photo_single')) {
                $upload_data = $this->upload->data();
                $is_primary = ($existing_count === 0 && $i === 0) ? 1 : 0;
                $this->Product_model->add_image($product_id, 'uploads/products/' . $upload_data['file_name'], $is_primary, $existing_count + $i);
            }
        }
    }
}
