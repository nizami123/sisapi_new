<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Artikel_model');
	}

	public function index()
	{
		$kategori = $this->input->get('kategori');
		$data['artikel'] = $this->Artikel_model->list_terbit($kategori, 12, 0);
		$data['kategori_filter'] = $kategori;
		$data['meta_title'] = 'Artikel Peternakan - SISAPI';
		$this->load->view('templates/header', $data);
		$this->load->view('artikel/index', $data);
		$this->load->view('templates/footer', $data);
	}

	public function detail($slug)
	{
		$artikel = $this->Artikel_model->get_by_slug($slug);
		if ( ! $artikel) show_404();

		$this->Artikel_model->tambah_view($artikel->id);

		$data['artikel'] = $artikel;
		$data['meta_title'] = $artikel->meta_title ?: $artikel->judul;
		$data['meta_description'] = $artikel->meta_description ?: mb_substr(strip_tags($artikel->ringkasan ?: $artikel->konten), 0, 155);
		$this->load->view('templates/header', $data);
		$this->load->view('artikel/detail', $data);
		$this->load->view('templates/footer', $data);
	}
}
