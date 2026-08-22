<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Controller SISAPI
 * Menangani autentikasi & RBAC (Role Based Access Control)
 *
 * Role ID acuan (tabel roles):
 *  1 = super_admin (Dinas)
 *  2 = admin_peternak
 *  3 = peternak
 *  4 = guest (tidak login)
 */
class MY_Controller extends CI_Controller {

	protected $current_user  = NULL;
	protected $current_role  = 'guest';

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('logged_in')) {
			$this->current_user = array(
				'id'       => $this->session->userdata('user_id'),
				'username' => $this->session->userdata('username'),
				'role_id'  => $this->session->userdata('role_id'),
				'peternak_id' => $this->session->userdata('peternak_id'),
			);
			$this->current_role = $this->session->userdata('role_name');
		}
	}

	/**
	 * Wajib login (role apapun)
	 */
	protected function require_login()
	{
		if (empty($this->current_user)) {
			$this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
			redirect('login');
		}
	}

	/**
	 * Wajib salah satu role dari daftar yang diizinkan
	 * Contoh: $this->require_role(array('super_admin','admin_peternak'));
	 */
	protected function require_role($allowed_roles = array())
	{
		$this->require_login();
		if ( ! in_array($this->current_role, $allowed_roles)) {
			show_error('Anda tidak memiliki akses ke halaman ini (403 Forbidden).', 403, 'Akses Ditolak');
		}
	}

	/**
	 * Khusus peternak yang statusnya sudah disetujui admin
	 */
	protected function require_peternak_approved()
	{
		$this->require_role(array('peternak'));
		$peternak = $this->Peternak_model->get_by_user_id($this->current_user['id']);
		if ( ! $peternak || $peternak->status_verifikasi !== 'disetujui') {
			$this->session->set_flashdata('error', 'Akun peternak Anda belum diverifikasi oleh Admin Dinas. Anda belum bisa mengunggah ternak.');
			redirect('dashboard/profil');
		}
		return $peternak;
	}

	/**
	 * Catat ke audit log (log_aktivitas)
	 */
	protected function catat_log($aksi, $modul, $referensi_id = NULL, $deskripsi = '')
	{
		$this->db->insert('log_aktivitas', array(
			'user_id'      => $this->current_user['id'] ?? NULL,
			'aksi'         => $aksi,
			'modul'        => $modul,
			'referensi_id' => $referensi_id,
			'deskripsi'    => $deskripsi,
			'ip_address'   => $this->input->ip_address(),
			'created_at'   => date('Y-m-d H:i:s'),
		));
	}
}
