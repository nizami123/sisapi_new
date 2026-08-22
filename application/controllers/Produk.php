<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	public function index($kategori_slug = NULL)
	{
		$filters = array(
			'kabupaten_id'  => $this->input->get('kabupaten_id'),
			'kecamatan_id'  => $this->input->get('kecamatan_id'),
			'harga_min'     => $this->input->get('harga_min'),
			'harga_max'     => $this->input->get('harga_max'),
			'jenis_kelamin' => $this->input->get('jenis_kelamin'),
			'bobot_min'     => $this->input->get('bobot_min'),
			'bobot_max'     => $this->input->get('bobot_max'),
			'umur_max'      => $this->input->get('umur_max'),
			'q'             => $this->input->get('q'),
		);

		if ($kategori_slug) {
			$kat = $this->Kategori_model->get_by_slug($kategori_slug);
			if ($kat) $filters['kategori_id'] = $kat->id;
		} elseif ($this->input->get('kategori_id')) {
			$filters['kategori_id'] = $this->input->get('kategori_id');
		}

		$sort   = $this->input->get('sort') ?: 'terbaru';
		$page   = max(1, (int) $this->input->get('page'));
		$limit  = 12;
		$offset = ($page - 1) * $limit;

		$data['produk']     = $this->Produk_model->get_listing($filters, $sort, $limit, $offset);
		$data['total']      = $this->Produk_model->count_listing($filters);
		$data['page']       = $page;
		$data['total_page'] = ceil($data['total'] / $limit);
		$data['sort']       = $sort;
		$data['filters']    = $filters;
		$data['kategori']   = $this->Kategori_model->get_all_active();
		$data['kabupaten']  = $this->Wilayah_model->get_semua_kabupaten();
		$data['meta_title'] = 'Katalog Ternak - SISAPI';

		$this->load->view('templates/header', $data);
		$this->load->view('produk/list', $data);
		$this->load->view('templates/footer', $data);
	}

	public function detail($slug)
	{
		$produk = $this->Produk_model->get_by_slug($slug);
		if ( ! $produk || $produk->status_verifikasi !== 'disetujui') {
			show_404();
		}

		$this->Produk_model->tambah_view($produk->id);

		$data['produk'] = $produk;
		$data['galeri'] = $this->Produk_model->get_galeri($produk->id);
		$data['wa_link'] = link_whatsapp($produk->nomor_wa, $produk->nama_ternak);
		$data['meta_title'] = $produk->meta_title ?: ($produk->nama_ternak . ' - SISAPI');
		$data['meta_description'] = $produk->meta_description ?: mb_substr(strip_tags($produk->deskripsi), 0, 155);

		$this->load->view('templates/header', $data);
		$this->load->view('produk/detail', $data);
		$this->load->view('templates/footer', $data);
	}

	/** Dipanggil via AJAX/JS saat tombol WA diklik, sebelum window.open() */
	public function catat_klik_wa($produk_id)
	{
		$this->Produk_model->tambah_klik_wa((int) $produk_id);
		$produk = $this->db->where('id', $produk_id)->get('produk')->row();
		if ($produk) {
			$this->db->insert('kontak', array(
				'produk_id'   => $produk_id,
				'peternak_id' => $produk->peternak_id,
				'ip_address'  => $this->input->ip_address(),
				'created_at'  => date('Y-m-d H:i:s'),
			));
		}
		echo json_encode(array('status' => 'ok'));
	}

	public function cari()
	{
		redirect('produk?q=' . urlencode($this->input->get('q')));
	}

	public function autocomplete()
	{
		$q = $this->input->get('q');
		$result = $q ? $this->Produk_model->autocomplete($q) : array();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}
