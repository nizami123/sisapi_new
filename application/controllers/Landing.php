<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Banner_model', 'Statistik_model', 'Artikel_model'));
	}

	public function index()
	{
		$this->Statistik_model->catat_kunjungan('landing');

		$data['banners']          = $this->Banner_model->get_active();
		$data['kategori']         = $this->Kategori_model->get_all_active();
		$data['produk_terbaru']   = $this->Produk_model->terbaru(8);
		$data['produk_terpopuler']= $this->Produk_model->terpopuler(8);
		$data['peternak_terpercaya'] = $this->Peternak_model->peternak_terpercaya(6);
		$data['statistik']        = $this->Statistik_model->ringkasan();
		$data['artikel']          = $this->Artikel_model->list_terbit(NULL, 3);
		$data['kabupaten']        = $this->Wilayah_model->get_semua_kabupaten();

		$data['meta_title']       = 'SISAPI - Marketplace Peternakan Indonesia Terpercaya';
		$data['meta_description'] = 'Temukan sapi, kambing, domba, unggas, pakan, dan hasil ternak dari peternak terverifikasi di seluruh Indonesia.';

		$this->load->view('templates/header', $data);
		$this->load->view('landing/index', $data);
		$this->load->view('templates/footer', $data);
	}

	public function tentang()
	{
		$data['meta_title'] = 'Tentang SISAPI';
		$this->load->view('templates/header', $data);
		$this->load->view('landing/tentang', $data);
		$this->load->view('templates/footer', $data);
	}

	public function daftar_peternak()
	{
		$data['peternak'] = $this->Peternak_model->peternak_terpercaya(50);
		$data['meta_title'] = 'Daftar Peternak Terpercaya - SISAPI';
		$this->load->view('templates/header', $data);
		$this->load->view('landing/daftar_peternak', $data);
		$this->load->view('templates/footer', $data);
	}

	public function profil_peternak($peternak_id)
	{
		$data['peternak'] = $this->Peternak_model->get_by_id($peternak_id);
		if ( ! $data['peternak'] || $data['peternak']->status_verifikasi !== 'disetujui') {
			show_404();
		}
		$data['produk'] = $this->Produk_model->get_by_peternak($peternak_id);
		$data['meta_title'] = $data['peternak']->nama_lengkap . ' - Peternak Terpercaya SISAPI';
		$this->load->view('templates/header', $data);
		$this->load->view('landing/profil_peternak', $data);
		$this->load->view('templates/footer', $data);
	}
}
