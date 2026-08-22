<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('identity', 'Username/Email', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run()) {
				$user = $this->User_model->get_by_username_or_email($this->input->post('identity', TRUE));

			
				if ($user) {

					if ($user->status !== 'aktif') {
						$this->session->set_flashdata('error', 'Akun Anda belum aktif atau sedang ditangguhkan.');
						redirect('login');
					}

					$peternak_id = NULL;
					if ($user->nama_role === 'peternak') {
						$p = $this->Peternak_model->get_by_user_id($user->id);
						$peternak_id = $p ? $p->id : NULL;
					}

					$this->session->set_userdata(array(
						'logged_in'   => TRUE,
						'user_id'     => $user->id,
						'username'    => $user->username,
						'role_id'     => $user->role_id,
						'role_name'   => $user->nama_role,
						'peternak_id' => $peternak_id,
						'foto_profil' => $user->foto_profil,
					));

					$this->User_model->update_last_login($user->id);
					$this->db->insert('log_aktivitas', array(
						'user_id' => $user->id, 'aksi' => 'login', 'modul' => 'auth',
						'ip_address' => $this->input->ip_address(), 'created_at' => date('Y-m-d H:i:s'),
					));

					if ($user->nama_role === 'super_admin' || $user->nama_role === 'admin_peternak') {
						redirect('admin');
					}
					redirect('dashboard');
				}

				$this->session->set_flashdata('error', 'Username/Email atau password salah.');
				redirect('login');
			}
		}

		$data['meta_title'] = 'Login - SISAPI';
		$this->load->view('templates/header_auth', $data);
		$this->load->view('auth/login', $data);
		$this->load->view('templates/footer_auth', $data);
	}

	public function register()
	{
		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim|min_length[3]');
			$this->form_validation->set_rules('nik', 'NIK', 'required|exact_length[16]|numeric|is_unique[peternak.nik]');
			$this->form_validation->set_rules('no_kk', 'Nomor KK', 'required|exact_length[16]|numeric');
			$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
			$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
			$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
			$this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
			$this->form_validation->set_rules('provinsi_id', 'Provinsi', 'required');
			$this->form_validation->set_rules('kabupaten_id', 'Kabupaten', 'required');
			$this->form_validation->set_rules('kecamatan_id', 'Kecamatan', 'required');
			$this->form_validation->set_rules('desa_id', 'Desa', 'required');
			$this->form_validation->set_rules('nomor_hp', 'Nomor HP', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('username', 'Username', 'required|alpha_dash|min_length[4]|is_unique[users.username]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]');
			$this->form_validation->set_rules('setuju_syarat', 'Persetujuan', 'required');
			// g-recaptcha-response divalidasi di sisi server via callback ke Google API (lihat README)

			if ($this->form_validation->run()) {

				// -- upload berkas wajib --
				$foto_ktp     = $this->_upload_file('foto_ktp', 'upload_path_ktp');
				$foto_selfie  = $this->_upload_file('foto_selfie_ktp', 'upload_path_selfie');
				$foto_kandang = $this->_upload_file('foto_kandang', 'upload_path_kandang');
				$foto_profil  = $this->_upload_file('foto_profil', 'upload_path_profil');

				if ( ! $foto_ktp || ! $foto_selfie || ! $foto_kandang) {
					$this->session->set_flashdata('error', 'Foto KTP, Selfie KTP, dan Foto Kandang wajib diunggah. ' . $this->upload->display_errors());
					redirect('daftar-peternak');
				}

				$this->db->trans_start();

				$user_id = $this->User_model->create_user(array(
					'role_id'      => 3, // peternak
					'username'     => $this->input->post('username', TRUE),
					'email'        => $this->input->post('email', TRUE),
					'password'     => $this->input->post('password'),
					'nomor_hp'     => $this->input->post('nomor_hp', TRUE),
					'foto_profil'  => $foto_profil,
					'status'       => 'aktif', // login diizinkan, tapi jualan menunggu verifikasi peternak
				));

				$this->Peternak_model->create(array(
					'user_id'              => $user_id,
					'nama_lengkap'          => $this->input->post('nama_lengkap', TRUE),
					'nik'                   => $this->input->post('nik', TRUE),
					'no_kk'                 => $this->input->post('no_kk', TRUE),
					'tempat_lahir'          => $this->input->post('tempat_lahir', TRUE),
					'tanggal_lahir'         => $this->input->post('tanggal_lahir', TRUE),
					'jenis_kelamin'         => $this->input->post('jenis_kelamin', TRUE),
					'alamat'                => $this->input->post('alamat', TRUE),
					'provinsi_id'           => $this->input->post('provinsi_id', TRUE),
					'kabupaten_id'          => $this->input->post('kabupaten_id', TRUE),
					'kecamatan_id'          => $this->input->post('kecamatan_id', TRUE),
					'desa_id'               => $this->input->post('desa_id', TRUE),
					'kode_pos'              => $this->input->post('kode_pos', TRUE),
					'foto_ktp'              => $foto_ktp,
					'foto_selfie_ktp'       => $foto_selfie,
					'foto_kandang'          => $foto_kandang,
					'nama_kelompok_ternak'  => $this->input->post('nama_kelompok_ternak', TRUE),
					'jenis_usaha'           => $this->input->post('jenis_usaha', TRUE),
					'jumlah_ternak'         => (int) $this->input->post('jumlah_ternak', TRUE),
					'latitude'              => $this->input->post('latitude', TRUE),
					'longitude'             => $this->input->post('longitude', TRUE),
					'setuju_syarat'         => 1,
					'status_verifikasi'     => 'menunggu',
				));

				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE) {
					$this->session->set_flashdata('error', 'Pendaftaran gagal, silakan coba lagi.');
					redirect('daftar-peternak');
				}

				$this->db->insert('log_aktivitas', array(
					'user_id' => $user_id, 'aksi' => 'daftar_peternak', 'modul' => 'peternak',
					'referensi_id' => $user_id, 'ip_address' => $this->input->ip_address(), 'created_at' => date('Y-m-d H:i:s'),
				));

				// TODO: kirim email notifikasi "Pendaftaran diterima, menunggu verifikasi admin"
				$this->session->set_flashdata('success', 'Pendaftaran berhasil! Akun Anda akan aktif berjualan setelah diverifikasi oleh Admin Dinas.');
				redirect('login');
			}
		}

		$data['provinsi'] = $this->Wilayah_model->get_provinsi();
		$data['meta_title'] = 'Daftar Sebagai Peternak - SISAPI';
		$this->load->view('templates/header_auth', $data);
		$this->load->view('auth/register', $data);
		$this->load->view('templates/footer_auth', $data);
	}

	private function _upload_file($field, $config_path_key)
	{
		if (empty($_FILES[$field]['name'])) return NULL;

		$config['upload_path']   = $this->config->item($config_path_key);
		$config['allowed_types'] = $this->config->item('upload_allowed_types');
		$config['max_size']      = $this->config->item('upload_max_size');
		$config['encrypt_name']  = TRUE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if ($this->upload->do_upload($field)) {
			$d = $this->upload->data();
			return $d['file_name'];
		}
		return NULL;
	}

	public function logout()
	{
		if ($this->session->userdata('user_id')) {
			$this->db->insert('log_aktivitas', array(
				'user_id' => $this->session->userdata('user_id'), 'aksi' => 'logout', 'modul' => 'auth',
				'ip_address' => $this->input->ip_address(), 'created_at' => date('Y-m-d H:i:s'),
			));
		}
		$this->session->sess_destroy();
		redirect('login');
	}

	public function forgot_password()
	{
		// TODO: implementasi kirim link reset via email (queue + token di tabel users)
		$this->load->view('templates/header_auth');
		$this->load->view('auth/forgot_password');
		$this->load->view('templates/footer_auth');
	}
}
