<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik_model extends CI_Model {

	/** Ringkasan angka untuk landing page & dashboard admin */
	public function ringkasan()
	{
		return array(
			'total_peternak'   => $this->db->where('status_verifikasi', 'disetujui')->count_all_results('peternak'),
			'total_produk'     => $this->db->where('status_verifikasi', 'disetujui')->count_all_results('produk'),
			'total_kontak'     => $this->db->count_all_results('kontak'),
			'peternak_pending' => $this->db->where('status_verifikasi', 'menunggu')->count_all_results('peternak'),
			'produk_pending'   => $this->db->where('status_verifikasi', 'menunggu')->count_all_results('produk'),
		);
	}

	public function kategori_terlaris($limit = 6)
	{
		return $this->db->select('kategori.nama_kategori, COUNT(produk.id) AS total')
			->from('produk')
			->join('kategori', 'kategori.id = produk.kategori_id')
			->where('produk.status_verifikasi', 'disetujui')
			->group_by('kategori.id')
			->order_by('total', 'DESC')
			->limit($limit)
			->get()->result();
	}

	public function lokasi_terbanyak($limit = 6)
	{
		return $this->db->select('wilayah.nama, COUNT(produk.id) AS total')
			->from('produk')
			->join('wilayah', 'wilayah.id = produk.kabupaten_id')
			->where('produk.status_verifikasi', 'disetujui')
			->group_by('wilayah.id')
			->order_by('total', 'DESC')
			->limit($limit)
			->get()->result();
	}

	public function upload_per_bulan($bulan_terakhir = 6)
	{
		return $this->db->select("DATE_FORMAT(created_at, '%Y-%m') AS bulan, COUNT(*) AS total")
			->where('created_at >=', date('Y-m-d', strtotime("-{$bulan_terakhir} months")))
			->group_by('bulan')->order_by('bulan', 'ASC')
			->get('produk')->result();
	}

	public function pengunjung_harian($hari_terakhir = 14)
	{
		return $this->db->where('tanggal >=', date('Y-m-d', strtotime("-{$hari_terakhir} days")))
			->order_by('tanggal', 'ASC')->get('statistik')->result();
	}

	public function catat_kunjungan($halaman)
	{
		$tanggal = date('Y-m-d');

		$this->db->insert('pengunjung', array(
			'ip_address' => $this->input->ip_address(),
			'halaman'    => $halaman,
			'user_agent' => $this->input->user_agent(),
			'referrer'   => $this->input->server('HTTP_REFERER'),
			'tanggal'    => $tanggal,
			'created_at' => date('Y-m-d H:i:s'),
		));

		$exists = $this->db->where('tanggal', $tanggal)->get('statistik')->row();

		if ($exists) {
			$this->db
				->set('total_pengunjung', 'total_pengunjung + 1', FALSE)
				->where('tanggal', $tanggal)
				->update('statistik');
		} else {
			$this->db->insert('statistik', array(
				'tanggal' => $tanggal,
				'total_pengunjung' => 1
			));
		}
	}
}
