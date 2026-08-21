<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bersihkan nomor WhatsApp ke format internasional (62xxxx) tanpa + / spasi.
 */
if (!function_exists('format_whatsapp_number')) {
    function format_whatsapp_number($number)
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        } elseif (substr($number, 0, 2) !== '62') {
            $number = '62' . $number;
        }
        return $number;
    }
}

/**
 * Bangun link wa.me dengan pesan otomatis untuk sebuah produk.
 */
if (!function_exists('whatsapp_product_link')) {
    function whatsapp_product_link($phone, $product_name)
    {
        $number = format_whatsapp_number($phone);
        $message = "Halo, saya melihat produk {$product_name} di SISAPI. Apakah masih tersedia?";
        return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
    }
}

/**
 * Hitung jarak antara dua koordinat (haversine) dalam kilometer.
 */
if (!function_exists('haversine_distance_km')) {
    function haversine_distance_km($lat1, $lon1, $lat2, $lon2)
    {
        if ($lat1 === NULL || $lon1 === NULL || $lat2 === NULL || $lon2 === NULL) {
            return NULL;
        }
        $earth_radius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earth_radius * $c, 1);
    }
}

if (!function_exists('format_distance')) {
    function format_distance($km)
    {
        if ($km === NULL) return '';
        if ($km < 1) {
            return '±' . round($km * 1000) . ' m dari lokasi Anda';
        }
        return '±' . number_format($km, 1, ',', '.') . ' km dari lokasi Anda';
    }
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($number)
    {
        return 'Rp ' . number_format((float) $number, 0, ',', '.');
    }
}
