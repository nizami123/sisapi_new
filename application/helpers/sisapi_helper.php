<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('format_rupiah')) {
	function format_rupiah($angka) {
		return 'Rp ' . number_format((float) $angka, 0, ',', '.');
	}
}

if ( ! function_exists('buat_slug')) {
	function buat_slug($string) {
		$string = strtolower(trim($string));
		$string = preg_replace('/[^a-z0-9]+/', '-', $string);
		return trim($string, '-') . '-' . substr(uniqid(), -5);
	}
}

if ( ! function_exists('link_whatsapp')) {
	/**
	 * Membuat link wa.me sesuai spesifikasi:
	 * https://wa.me/NOMORHP?text=Halo%20Saya%20tertarik%20dengan%20ternak%20yang%20Anda%20jual%20di%20SISAPI
	 */
	function link_whatsapp($nomor_hp, $nama_produk = '') {
		$nomor_hp = preg_replace('/[^0-9]/', '', $nomor_hp);
		if (substr($nomor_hp, 0, 1) === '0') {
			$nomor_hp = '62' . substr($nomor_hp, 1);
		}
		$pesan = 'Halo Saya tertarik dengan ternak yang Anda jual di SISAPI';
		if ($nama_produk !== '') {
			$pesan .= ': ' . $nama_produk;
		}
		return 'https://wa.me/' . $nomor_hp . '?text=' . rawurlencode($pesan);
	}
}

if ( ! function_exists('badge_status_verifikasi')) {
	function badge_status_verifikasi($status) {
		$map = array(
			'menunggu'  => '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Menunggu</span>',
			'disetujui' => '<span class="badge bg-success"><i class="bi bi-patch-check-fill"></i> Terverifikasi</span>',
			'ditolak'   => '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ditolak</span>',
			'perbaikan' => '<span class="badge bg-info text-dark"><i class="bi bi-pencil-square"></i> Perlu Perbaikan</span>',
		);
		return $map[$status] ?? '<span class="badge bg-secondary">' . esc($status) . '</span>';
	}
}

if ( ! function_exists('esc')) {
	function esc($string) {
		return htmlspecialchars((string) $string, ENT_QUOTES, 'UTF-8');
	}
}

if ( ! function_exists('umur_ternak_text')) {
	function umur_ternak_text($tahun, $bulan) {
		$parts = array();
		if ($tahun > 0) $parts[] = $tahun . ' tahun';
		if ($bulan > 0) $parts[] = $bulan . ' bulan';
		return $parts ? implode(' ', $parts) : '-';
	}
}
