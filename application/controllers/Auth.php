<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('User_model');
        $this->load->model('Seller_model');
        $this->load->model('Region_model');
    }

    public function login()
    {
        if ($this->session->userdata('user_id')) {
            redirect($this->_home_for_role($this->session->userdata('role')));
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run()) {
                $email = $this->input->post('email', TRUE);
                $password = $this->input->post('password');
                $user = $this->User_model->find_by_email($email);

                if ($user && password_verify($password, $user['password'])) {
                    if ($user['status'] === 'suspended') {
                        $data['error'] = 'Akun Anda dinonaktifkan. Hubungi admin SISAPI.';
                    } else {
                        $this->session->set_userdata(array(
                            'user_id' => $user['id'],
                            'role'    => $user['role'],
                            'name'    => $user['name'],
                        ));
                        redirect($this->_home_for_role($user['role']));
                        return;
                    }
                } else {
                    $data['error'] = 'Email atau password salah.';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }

        $data['title'] = 'Login - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('auth/login', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Pendaftaran pembeli (opsional/ringan — pembeli sebetulnya bisa
     * langsung menghubungi penjual tanpa akun, akun hanya untuk favorit dsb).
     */
    public function register()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('phone_whatsapp', 'No. WhatsApp', 'required|min_length[9]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            if ($this->form_validation->run()) {
                $user_id = $this->User_model->create(array(
                    'name' => $this->input->post('name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone_whatsapp' => $this->input->post('phone_whatsapp', TRUE),
                    'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'role' => 'buyer',
                    'status' => 'active'
                ));
                $this->session->set_userdata(array('user_id' => $user_id, 'role' => 'buyer', 'name' => $this->input->post('name', TRUE)));
                $this->session->set_flashdata('success', 'Pendaftaran berhasil! Selamat datang di SISAPI.');
                redirect('/');
                return;
            } else {
                $data['error'] = validation_errors();
            }
        }

        $data['title'] = 'Daftar Pembeli - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('auth/register', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Pendaftaran peternak/penjual — termasuk profil peternakan & titik lokasi peta.
     */
    public function register_seller()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('phone_whatsapp', 'No. WhatsApp', 'required|min_length[9]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('farm_name', 'Nama Peternakan', 'required');
            $this->form_validation->set_rules('address', 'Alamat', 'required');
            $this->form_validation->set_rules('latitude', 'Titik lokasi peta', 'required');
            $this->form_validation->set_rules('longitude', 'Titik lokasi peta', 'required');

            if ($this->form_validation->run()) {
                $user_id = $this->User_model->create(array(
                    'name' => $this->input->post('name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone_whatsapp' => $this->input->post('phone_whatsapp', TRUE),
                    'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'role' => 'seller',
                    'status' => 'active'
                ));

                $photo_path = NULL;
                if (!empty($_FILES['photo']['name'])) {
                    $photo_path = $this->_upload_seller_photo($user_id);
                }
                if ($photo_path) {
                    $this->User_model->update($user_id, array('photo' => $photo_path));
                }

                $this->Seller_model->create(array(
                    'user_id' => $user_id,
                    'farm_name' => $this->input->post('farm_name', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'address' => $this->input->post('address', TRUE),
                    'village_id' => $this->input->post('village_id') ?: NULL,
                    'district_id' => $this->input->post('district_id') ?: NULL,
                    'regency_id' => $this->input->post('regency_id') ?: NULL,
                    'province_id' => $this->input->post('province_id') ?: NULL,
                    'latitude' => $this->input->post('latitude'),
                    'longitude' => $this->input->post('longitude'),
                    'is_verified' => 0
                ));

                $this->session->set_userdata(array('user_id' => $user_id, 'role' => 'seller', 'name' => $this->input->post('name', TRUE)));
                $this->session->set_flashdata('success', 'Pendaftaran berhasil! Akun peternak Anda berstatus "Menunggu Verifikasi" — admin SISAPI akan meninjau dalam 1x24 jam.');
                redirect('dashboard');
                return;
            } else {
                $data['error'] = validation_errors();
            }
        }

        $data['provinces'] = $this->Region_model->provinces();
        $data['title'] = 'Daftar Sebagai Peternak - SISAPI';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('auth/register_seller', $data);
        $this->load->view('templates/footer', $data);
    }

    protected function _upload_seller_photo($user_id)
    {
        $config['upload_path'] = './uploads/sellers/';
        $config['allowed_types'] = $this->config->item('sisapi_allowed_image_types');
        $config['max_size'] = $this->config->item('sisapi_upload_max_size');
        $config['file_name'] = 'seller_' . $user_id . '_' . time();
        $config['encrypt_name'] = FALSE;

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('photo')) {
            $upload_data = $this->upload->data();
            return 'uploads/sellers/' . $upload_data['file_name'];
        }
        return NULL;
    }

    protected function _home_for_role($role)
    {
        if ($role === 'admin') return 'admin';
        if ($role === 'seller') return 'dashboard';
        return '/';
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}
