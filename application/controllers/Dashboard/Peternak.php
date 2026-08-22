<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peternak extends MY_Controller {

	private $peternak;

	public function __construct()
	{
		parent::__construct();
		$this->require_role(array('peternak'));
		$this->peternak = $this->Peternak_model->get_by_user_id($this->current_user['id']);
	}

	public function index()
	{
		$data['peternak'] = $this->peternak;
		$data['jumlah_produk'] = count($this->Produk_model->get_by_peternak($this->peternak->id));
		$data['produk_terbaru'] = array_slice($this->Produk_model->get_by_peternak($this->peternak->id), 0, 5);
		$this->load->view('templates/header_dashboard', array('title' => 'Dashboard Peternak', 'active' => 'dashboard'));
		$this->load->view('dashboard/peternak/index', $data);
		$this->load->view('templates/footer_dashboard');
	}

	public function profil()
	{
		if ($this->input->method() === 'post') {
			$this->Peternak_model->update($this->peternak->id, array(
				'alamat' => $this->input->post('alamat', TRUE),
				'nama_kelompok_ternak' => $this->input->post('nama_kelompok_ternak', TRUE),
				'jenis_usaha' => $this->input->post('jenis_usaha', TRUE),
			));
			$this->catat_log('update_profil', 'peternak', $this->peternak->id);
			$this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
			redirect('dashboard/profil');
		}

		$data['peternak'] = $this->peternak;
		$this->load->view('templates/header_dashboard', array('title' => 'Profil Saya', 'active' => 'profil'));
		$this->load->view('dashboard/peternak/profil', $data);
		$this->load->view('templates/footer_dashboard');
	}

	public function produk()
	{
		$data['produk'] = $this->Produk_model->get_by_peternak($this->peternak->id);
		$data['status_verif_akun'] = $this->peternak->status_verifikasi;
		$this->load->view('templates/header_dashboard', array('title' => 'Data Ternak Saya', 'active' => 'produk'));
		$this->load->view('dashboard/peternak/produk', $data);
		$this->load->view('templates/footer_dashboard');
	}

	public function tambah_produk()
	{
		// Wajib sudah diverifikasi sebelum boleh upload ternak (verifikasi berjenjang)
		if ($this->peternak->status_verifikasi !== 'disetujui') {
			$this->session->set_flashdata('error', 'Akun Anda belum diverifikasi Admin Dinas. Anda belum dapat menambahkan ternak.');
			redirect('dashboard/produk');
		}

		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('kategori_id', 'Kategori', 'required');
			$this->form_validation->set_rules('nama_ternak', 'Nama Ternak', 'required|trim');
			$this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
			$this->form_validation->set_rules('nomor_wa', 'Nomor WhatsApp', 'required|trim');

			if ($this->form_validation->run()) {
				$config['upload_path']   = $this->config->item('upload_path_produk');
				$config['allowed_types'] = $this->config->item('upload_allowed_types');
				$config['max_size']      = $this->config->item('upload_max_size');
				$config['encrypt_name']  = TRUE;
				$this->load->library('upload', $config);

				$foto_utama = NULL;
				if ($this->upload->do_upload('foto_utama')) {
					$foto_utama = $this->upload->data('file_name');
				}

				$produk_id = $this->Produk_model->create(array(
					'peternak_id'      => $this->peternak->id,
					'kategori_id'      => $this->input->post('kategori_id', TRUE),
					'nama_ternak'      => $this->input->post('nama_ternak', TRUE),
					'harga'            => $this->input->post('harga', TRUE),
					'deskripsi'        => $this->input->post('deskripsi', TRUE),
					'ras'              => $this->input->post('ras', TRUE),
					'jenis_kelamin'    => $this->input->post('jenis_kelamin', TRUE),
					'umur_tahun'       => (int) $this->input->post('umur_tahun', TRUE),
					'umur_bulan'       => (int) $this->input->post('umur_bulan', TRUE),
					'bobot_kg'         => $this->input->post('bobot_kg', TRUE),
					'warna'            => $this->input->post('warna', TRUE),
					'status_kesehatan' => $this->input->post('status_kesehatan', TRUE),
					'status_vaksin'    => $this->input->post('status_vaksin', TRUE),
					'kabupaten_id'     => $this->input->post('kabupaten_id', TRUE),
					'kecamatan_id'     => $this->input->post('kecamatan_id', TRUE),
					'alamat_lengkap'   => $this->input->post('alamat_lengkap', TRUE),
					'latitude'         => $this->input->post('latitude', TRUE),
					'longitude'        => $this->input->post('longitude', TRUE),
					'foto_utama'       => $foto_utama,
					'video_url'        => $this->input->post('video_url', TRUE),
					'nomor_wa'         => $this->input->post('nomor_wa', TRUE),
					'status_verifikasi'=> 'menunggu',
				));

				// upload galeri (banyak file)
				if ( ! empty($_FILES['galeri']['name'][0])) {
					foreach ($_FILES['galeri']['name'] as $i => $name) {
						if (empty($name)) continue;
						$_FILES['galeri_single']['name'] = $_FILES['galeri']['name'][$i];
						$_FILES['galeri_single']['type'] = $_FILES['galeri']['type'][$i];
						$_FILES['galeri_single']['tmp_name'] = $_FILES['galeri']['tmp_name'][$i];
						$_FILES['galeri_single']['error'] = $_FILES['galeri']['error'][$i];
						$_FILES['galeri_single']['size'] = $_FILES['galeri']['size'][$i];

						$this->upload->initialize($config);
						if ($this->upload->do_upload('galeri_single')) {
							$this->db->insert('foto_produk', array(
								'produk_id' => $produk_id,
								'path_foto' => $this->upload->data('file_name'),
								'urutan'    => $i,
							));
						}
					}
				}

				$this->catat_log('tambah_produk', 'produk', $produk_id, 'Peternak menambahkan ternak baru');
				$this->session->set_flashdata('success', 'Ternak berhasil diunggah dan menunggu persetujuan Admin Dinas.');
				redirect('dashboard/produk');
			}
		}

		$data['kategori'] = $this->Kategori_model->get_all_active();
		$data['kabupaten'] = $this->Wilayah_model->get_semua_kabupaten();
		$this->load->view('templates/header_dashboard', array('title' => 'Tambah Ternak', 'active' => 'produk'));
		$this->load->view('dashboard/peternak/tambah_produk', $data);
		$this->load->view('templates/footer_dashboard');
	}

	public function edit_produk($id)
	{
		$produk = $this->db->where('id', $id)->where('peternak_id', $this->peternak->id)->get('produk')->row();
		if ( ! $produk) show_404();

		if ($this->input->method() === 'post') {
			$this->Produk_model->update($id, array(
				'nama_ternak'   => $this->input->post('nama_ternak', TRUE),
				'harga'         => $this->input->post('harga', TRUE),
				'deskripsi'     => $this->input->post('deskripsi', TRUE),
				'bobot_kg'      => $this->input->post('bobot_kg', TRUE),
				'status_verifikasi' => 'menunggu', // perubahan wajib diverifikasi ulang
			));
			$this->catat_log('edit_produk', 'produk', $id);
			$this->session->set_flashdata('success', 'Perubahan disimpan, menunggu verifikasi ulang admin.');
			redirect('dashboard/produk');
		}

		$data['produk'] = $produk;
		$data['kategori'] = $this->Kategori_model->get_all_active();
		$this->load->view('templates/header_dashboard', array('title' => 'Edit Ternak', 'active' => 'produk'));
		$this->load->view('dashboard/peternak/edit_produk', $data);
		$this->load->view('templates/footer_dashboard');
	}

	public function hapus_produk($id)
	{
		$this->db->where('id', $id)->where('peternak_id', $this->peternak->id)->delete('produk');
		$this->catat_log('hapus_produk', 'produk', $id);
		$this->session->set_flashdata('success', 'Ternak berhasil dihapus.');
		redirect('dashboard/produk');
	}

	public function statistik()
	{
		$produk = $this->Produk_model->get_by_peternak($this->peternak->id);
		$data['total_dilihat'] = array_sum(array_column($produk, 'jumlah_dilihat'));
		$data['total_klik_wa'] = array_sum(array_column($produk, 'jumlah_klik_wa'));
		$data['produk'] = $produk;
		$this->load->view('templates/header_dashboard', array('title' => 'Statistik', 'active' => 'statistik'));
		$this->load->view('dashboard/peternak/statistik', $data);
		$this->load->view('templates/footer_dashboard');
	}

	public function pesan()
	{
		// Placeholder - pengembangan fitur chat langsung (lihat roadmap)
		$this->load->view('templates/header_dashboard', array('title' => 'Pesan', 'active' => 'pesan'));
		$this->load->view('dashboard/peternak/pesan');
		$this->load->view('templates/footer_dashboard');
	}

	public function pengaturan()
	{
		if ($this->input->method() === 'post' && $this->input->post('password_baru')) {
			// TODO: validasi password lama, lalu update hash password_baru ke tabel users
			$this->session->set_flashdata('success', 'Password berhasil diperbarui.');
			redirect('dashboard/pengaturan');
		}
		$this->load->view('templates/header_dashboard', array('title' => 'Pengaturan', 'active' => 'pengaturan'));
		$this->load->view('dashboard/peternak/pengaturan');
		$this->load->view('templates/footer_dashboard');
	}
}
