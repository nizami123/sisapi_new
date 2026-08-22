<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		// Kedua role admin boleh masuk; beberapa menu (User & Pengaturan) dibatasi super_admin saja di view/aksi
		$this->require_role(array('super_admin', 'admin_peternak'));
		$this->load->model(array('Statistik_model', 'Artikel_model', 'Banner_model', 'LogAktivitas_model'));
	}

	public function index()
	{
		$data['statistik']         = $this->Statistik_model->ringkasan();
		$data['kategori_terlaris'] = $this->Statistik_model->kategori_terlaris();
		$data['lokasi_terbanyak']  = $this->Statistik_model->lokasi_terbanyak();
		$data['upload_per_bulan']  = $this->Statistik_model->upload_per_bulan();
		$data['pengunjung_harian'] = $this->Statistik_model->pengunjung_harian();

		$this->load->view('templates/header_admin', array('title' => 'Dashboard Admin', 'active' => 'dashboard'));
		$this->load->view('dashboard/admin/index', $data);
		$this->load->view('templates/footer_admin');
	}

	// ---------------- MASTER KATEGORI ----------------
	public function kategori()
	{
		if ($this->input->method() === 'post') {
			$this->Kategori_model->create(array(
				'nama_kategori' => $this->input->post('nama_kategori', TRUE),
				'icon'          => $this->input->post('icon', TRUE),
				'deskripsi'     => $this->input->post('deskripsi', TRUE),
				'status'        => 1,
				'urutan'        => (int) $this->input->post('urutan', TRUE),
			));
			$this->catat_log('tambah_kategori', 'kategori');
			$this->session->set_flashdata('success', 'Kategori berhasil ditambahkan.');
			redirect('admin/kategori');
		}
		$data['kategori'] = $this->Kategori_model->get_all();
		$this->load->view('templates/header_admin', array('title' => 'Master Kategori', 'active' => 'kategori'));
		$this->load->view('dashboard/admin/kategori', $data);
		$this->load->view('templates/footer_admin');
	}

	// ---------------- MASTER WILAYAH ----------------
	public function wilayah()
	{
		if ($this->input->method() === 'post') {
			$this->Wilayah_model->create(
				$this->input->post('nama', TRUE),
				$this->input->post('tingkat', TRUE),
				$this->input->post('parent_id', TRUE) ?: NULL,
				$this->input->post('kode', TRUE)
			);
			$this->catat_log('tambah_wilayah', 'wilayah');
			$this->session->set_flashdata('success', 'Data wilayah ditambahkan.');
			redirect('admin/wilayah');
		}
		$data['provinsi'] = $this->Wilayah_model->get_provinsi();
		$this->load->view('templates/header_admin', array('title' => 'Master Wilayah', 'active' => 'wilayah'));
		$this->load->view('dashboard/admin/wilayah', $data);
		$this->load->view('templates/footer_admin');
	}

	// ---------------- DATA & VERIFIKASI PETERNAK ----------------
	public function data_peternak()
	{
		$status = $this->input->get('status');
		$data['peternak'] = $this->Peternak_model->list_peternak($status, 50, 0);
		$data['status_filter'] = $status;
		$data['jumlah_menunggu'] = $this->Peternak_model->count_by_status('menunggu');
		$this->load->view('templates/header_admin', array('title' => 'Data Peternak', 'active' => 'peternak'));
		$this->load->view('dashboard/admin/data_peternak', $data);
		$this->load->view('templates/footer_admin');
	}

	public function verifikasi_peternak($id)
	{
		$peternak = $this->Peternak_model->get_by_id($id);
		if ( ! $peternak) show_404();

		if ($this->input->method() === 'post') {
			$aksi = $this->input->post('aksi'); // disetujui | ditolak | perbaikan
			$catatan = $this->input->post('catatan', TRUE);

			$this->Peternak_model->set_status($id, $aksi, $catatan, $this->current_user['id']);
			$this->catat_log('verifikasi_peternak_' . $aksi, 'peternak', $id, $catatan);

			// TODO: kirim notifikasi email/in-app ke peternak sesuai hasil verifikasi
			$this->session->set_flashdata('success', 'Status verifikasi peternak berhasil diperbarui.');
			redirect('admin/peternak');
		}

		$data['peternak'] = $peternak;
		$data['riwayat'] = $this->db->where('peternak_id', $id)->order_by('created_at', 'DESC')
			->get('approval_peternak')->result();
		$this->load->view('templates/header_admin', array('title' => 'Verifikasi Peternak', 'active' => 'peternak'));
		$this->load->view('dashboard/admin/verifikasi_peternak', $data);
		$this->load->view('templates/footer_admin');
	}

	// ---------------- DATA & VERIFIKASI PRODUK ----------------
	public function data_produk()
	{
		$status = $this->input->get('status');
		$data['produk'] = $this->Produk_model->list_for_admin($status, 50, 0);
		$data['status_filter'] = $status;
		$data['jumlah_menunggu'] = $this->Produk_model->count_by_status('menunggu');
		$this->load->view('templates/header_admin', array('title' => 'Data Produk', 'active' => 'produk'));
		$this->load->view('dashboard/admin/data_produk', $data);
		$this->load->view('templates/footer_admin');
	}

	public function verifikasi_produk($id)
	{
		$produk = $this->db->select('produk.*, peternak.nama_lengkap AS nama_peternak, peternak.status_verifikasi AS status_peternak')
			->from('produk')->join('peternak', 'peternak.id = produk.peternak_id')
			->where('produk.id', $id)->get()->row();
		if ( ! $produk) show_404();

		if ($this->input->method() === 'post') {
			$aksi = $this->input->post('aksi'); // disetujui | ditolak
			$catatan = $this->input->post('catatan', TRUE);

			if ($aksi === 'edit') {
				$this->Produk_model->update($id, array(
					'nama_ternak' => $this->input->post('nama_ternak', TRUE),
					'harga'       => $this->input->post('harga', TRUE),
					'deskripsi'   => $this->input->post('deskripsi', TRUE),
				));
				$this->catat_log('edit_produk_admin', 'produk', $id, $catatan);
			} else {
				$this->Produk_model->set_status($id, $aksi, $catatan, $this->current_user['id']);
				$this->catat_log('verifikasi_produk_' . $aksi, 'produk', $id, $catatan);
			}

			// TODO: kirim notifikasi ke peternak
			$this->session->set_flashdata('success', 'Status verifikasi produk berhasil diperbarui.');
			redirect('admin/produk');
		}

		$data['produk'] = $produk;
		$data['galeri'] = $this->Produk_model->get_galeri($id);
		$this->load->view('templates/header_admin', array('title' => 'Verifikasi Produk', 'active' => 'produk'));
		$this->load->view('dashboard/admin/verifikasi_produk', $data);
		$this->load->view('templates/footer_admin');
	}

	// ---------------- ARTIKEL ----------------
	public function artikel()
	{
		if ($this->input->method() === 'post') {
			$this->Artikel_model->create(array(
				'judul'            => $this->input->post('judul', TRUE),
				'kategori_artikel' => $this->input->post('kategori_artikel', TRUE),
				'konten'           => $this->input->post('konten'), // rich text, disimpan apa adanya (sanitasi di helper terpisah)
				'ringkasan'        => $this->input->post('ringkasan', TRUE),
				'penulis_id'       => $this->current_user['id'],
				'status'           => $this->input->post('status', TRUE),
			));
			$this->catat_log('tambah_artikel', 'artikel');
			$this->session->set_flashdata('success', 'Artikel berhasil disimpan.');
			redirect('admin/artikel');
		}
		$data['artikel'] = $this->Artikel_model->get_all_admin();
		$this->load->view('templates/header_admin', array('title' => 'Artikel', 'active' => 'artikel'));
		$this->load->view('dashboard/admin/artikel', $data);
		$this->load->view('templates/footer_admin');
	}

	// ---------------- BANNER ----------------
	public function banner()
	{
		if ($this->input->method() === 'post') {
			$config['upload_path']   = $this->config->item('upload_path_banner');
			$config['allowed_types'] = $this->config->item('upload_allowed_types');
			$config['max_size']      = 4096;
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('gambar')) {
				$this->Banner_model->create(array(
					'judul'    => $this->input->post('judul', TRUE),
					'gambar'   => $this->upload->data('file_name'),
					'link_url' => $this->input->post('link_url', TRUE),
					'urutan'   => (int) $this->input->post('urutan', TRUE),
					'status'   => 1,
				));
				$this->catat_log('tambah_banner', 'banner');
				$this->session->set_flashdata('success', 'Banner berhasil ditambahkan.');
			} else {
				$this->session->set_flashdata('error', $this->upload->display_errors());
			}
			redirect('admin/banner');
		}
		$data['banner'] = $this->Banner_model->get_all();
		$this->load->view('templates/header_admin', array('title' => 'Banner', 'active' => 'banner'));
		$this->load->view('dashboard/admin/banner', $data);
		$this->load->view('templates/footer_admin');
	}

	// ---------------- LAPORAN & STATISTIK ----------------
	public function laporan()
	{
		$data['produk'] = $this->Produk_model->list_for_admin('disetujui', 1000, 0);
		// TODO: tombol ekspor PDF/Excel - lihat roadmap pengembangan (butuh library PhpSpreadsheet/mPDF/Dompdf)
		$this->load->view('templates/header_admin', array('title' => 'Laporan', 'active' => 'laporan'));
		$this->load->view('dashboard/admin/laporan', $data);
		$this->load->view('templates/footer_admin');
	}

	public function statistik()
	{
		$data['statistik'] = $this->Statistik_model->ringkasan();
		$data['upload_per_bulan'] = $this->Statistik_model->upload_per_bulan(12);
		$data['pengunjung_harian'] = $this->Statistik_model->pengunjung_harian(30);
		$this->load->view('templates/header_admin', array('title' => 'Statistik', 'active' => 'statistik'));
		$this->load->view('dashboard/admin/statistik', $data);
		$this->load->view('templates/footer_admin');
	}

	// ---------------- PENGATURAN WEBSITE ----------------
	public function pengaturan()
	{
		$this->require_role(array('super_admin'));
		if ($this->input->method() === 'post') {
			foreach ($this->input->post('setting') as $key => $value) {
				$this->db->where('key_setting', $key)->update('pengaturan', array('value_setting' => $value));
			}
			$this->catat_log('update_pengaturan', 'pengaturan');
			$this->session->set_flashdata('success', 'Pengaturan berhasil disimpan.');
			redirect('admin/pengaturan');
		}
		$data['pengaturan'] = $this->db->get('pengaturan')->result();
		$this->load->view('templates/header_admin', array('title' => 'Pengaturan Website', 'active' => 'pengaturan'));
		$this->load->view('dashboard/admin/pengaturan', $data);
		$this->load->view('templates/footer_admin');
	}

	// ---------------- MANAJEMEN USER (super admin only) ----------------
	public function manajemen_user()
	{
		$this->require_role(array('super_admin'));
		if ($this->input->method() === 'post') {
			$this->User_model->create_user(array(
				'role_id'  => $this->input->post('role_id', TRUE),
				'username' => $this->input->post('username', TRUE),
				'email'    => $this->input->post('email', TRUE),
				'password' => $this->input->post('password'),
				'status'   => 'aktif',
			));
			$this->catat_log('tambah_user_admin', 'user');
			$this->session->set_flashdata('success', 'User admin berhasil ditambahkan.');
			redirect('admin/user');
		}
		$data['users'] = $this->db->select('users.*, roles.nama_role')->from('users')
			->join('roles', 'roles.id = users.role_id')->get()->result();
		$this->load->view('templates/header_admin', array('title' => 'Manajemen User', 'active' => 'user'));
		$this->load->view('dashboard/admin/manajemen_user', $data);
		$this->load->view('templates/footer_admin');
	}

	// ---------------- LOG AKTIVITAS (audit trail) ----------------
	public function log_aktivitas()
	{
		$data['log'] = $this->LogAktivitas_model->list_log(array('modul' => $this->input->get('modul')), 100, 0);
		$this->load->view('templates/header_admin', array('title' => 'Log Aktivitas', 'active' => 'log'));
		$this->load->view('dashboard/admin/log_aktivitas', $data);
		$this->load->view('templates/footer_admin');
	}
}
