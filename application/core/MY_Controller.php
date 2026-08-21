<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base controller: menyediakan helper auth & role guard yang dipakai
 * oleh Seller_Controller dan Admin_Controller.
 */
class MY_Controller extends CI_Controller
{
    public $current_user = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('User_model');

        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $this->current_user = $this->User_model->find($user_id);
        }
    }

    protected function is_logged_in()
    {
        return (bool) $this->current_user;
    }

    protected function require_login($redirect = 'login')
    {
        if (!$this->is_logged_in()) {
            redirect($redirect);
        }
    }

    protected function require_role($role, $redirect = 'login')
    {
        $this->require_login($redirect);
        if ($this->current_user['role'] !== $role) {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }
}

class Seller_Controller extends MY_Controller
{
    public $seller_profile = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->require_role('seller');
        $this->load->model('Seller_model');
        $this->seller_profile = $this->Seller_model->find_by_user($this->current_user['id']);

        if (!$this->seller_profile) {
            redirect('daftar-peternak');
        }
    }
}

class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_role('admin');
    }
}
