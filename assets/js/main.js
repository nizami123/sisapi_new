// =========================================================
// SISAPI - main.js
// =========================================================

/**
 * Minta lokasi pengguna via geolocation browser, lalu reload halaman
 * pencarian dengan parameter lat/lng agar bisa hitung jarak & urutkan terdekat.
 */
function sisapiUseMyLocation() {
  if (!navigator.geolocation) {
    Swal.fire('Tidak didukung', 'Browser Anda tidak mendukung fitur lokasi.', 'warning');
    return;
  }
  Swal.fire({ title: 'Mencari lokasi Anda...', didOpen: () => Swal.showLoading(), allowOutsideClick: false });
  navigator.geolocation.getCurrentPosition(
    function (pos) {
      Swal.close();
      const url = new URL(window.location.href);
      url.searchParams.set('lat', pos.coords.latitude);
      url.searchParams.set('lng', pos.coords.longitude);
      url.searchParams.set('sort', 'terdekat');
      window.location.href = url.toString();
    },
    function () {
      Swal.close();
      Swal.fire('Lokasi tidak tersedia', 'Izin lokasi ditolak. Menampilkan hasil berdasarkan wilayah.', 'info');
    }
  );
}

/**
 * Klik tombol "Hubungi Penjual via WhatsApp": catat klik ke backend
 * (tanpa menunda), lalu buka wa.me di tab baru.
 */
function sisapiTrackWhatsapp(productId, waLink) {
  try {
    fetch(SISAPI_BASE_URL + 'product/track_whatsapp_click/' + productId, { method: 'POST', keepalive: true });
  } catch (e) { /* noop */ }
  window.open(waLink, '_blank');
}

/**
 * Toggle favorit produk via AJAX.
 */
function sisapiToggleFavorite(productId, btn) {
  fetch(SISAPI_BASE_URL + 'product/toggle_favorite/' + productId, { method: 'POST' })
    .then(r => r.json())
    .then(data => {
      if (data.status === 'need_login') {
        Swal.fire({
          title: 'Masuk diperlukan',
          text: 'Login untuk menyimpan favorit.',
          icon: 'info',
          confirmButtonText: 'Login',
          showCancelButton: true
        }).then(res => { if (res.isConfirmed) window.location.href = SISAPI_BASE_URL + 'login'; });
        return;
      }
      if (btn) {
        btn.classList.toggle('text-danger', data.favorited);
        const icon = btn.querySelector('i');
        if (icon) icon.className = data.favorited ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
      }
    });
}

/**
 * Share produk (Web Share API dengan fallback copy link).
 */
function sisapiShareProduct(title, url) {
  if (navigator.share) {
    navigator.share({ title: title, url: url }).catch(() => {});
  } else {
    navigator.clipboard.writeText(url);
    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Link disalin', showConfirmButton: false, timer: 1800 });
  }
}

/**
 * Dropdown wilayah bertingkat: Provinsi -> Kabupaten -> Kecamatan -> Desa.
 * Dipakai di form pendaftaran peternak & tambah listing.
 */
function sisapiInitRegionDropdowns(prefix) {
  const provinceEl = document.getElementById(prefix + '_province');
  const regencyEl = document.getElementById(prefix + '_regency');
  const districtEl = document.getElementById(prefix + '_district');
  const villageEl = document.getElementById(prefix + '_village');
  if (!provinceEl) return;

  function fillSelect(el, items, placeholder) {
    el.innerHTML = '<option value="">' + placeholder + '</option>';
    items.forEach(item => {
      const opt = document.createElement('option');
      opt.value = item.id;
      opt.textContent = item.name;
      el.appendChild(opt);
    });
    el.disabled = items.length === 0;
  }

  provinceEl.addEventListener('change', function () {
    fillSelect(regencyEl, [], 'Pilih Kabupaten...');
    fillSelect(districtEl, [], 'Pilih Kecamatan...');
    fillSelect(villageEl, [], 'Pilih Desa...');
    if (!this.value) return;
    fetch(SISAPI_BASE_URL + 'home/ajax_regencies/' + this.value)
      .then(r => r.json()).then(data => fillSelect(regencyEl, data, 'Pilih Kabupaten...'));
  });

  regencyEl.addEventListener('change', function () {
    fillSelect(districtEl, [], 'Pilih Kecamatan...');
    fillSelect(villageEl, [], 'Pilih Desa...');
    if (!this.value) return;
    fetch(SISAPI_BASE_URL + 'home/ajax_districts/' + this.value)
      .then(r => r.json()).then(data => fillSelect(districtEl, data, 'Pilih Kecamatan...'));
  });

  districtEl.addEventListener('change', function () {
    fillSelect(villageEl, [], 'Pilih Desa...');
    if (!this.value) return;
    fetch(SISAPI_BASE_URL + 'home/ajax_villages/' + this.value)
      .then(r => r.json()).then(data => fillSelect(villageEl, data, 'Pilih Desa...'));
  });
}

/**
 * Leaflet map picker: klik peta untuk menentukan latitude/longitude,
 * dipakai di form pendaftaran peternak & tambah listing.
 * @param {string} mapElId - id elemen div peta
 * @param {string} latInputId - id input hidden latitude
 * @param {string} lngInputId - id input hidden longitude
 * @param {number} defaultLat
 * @param {number} defaultLng
 */
function sisapiInitMapPicker(mapElId, latInputId, lngInputId, defaultLat, defaultLng) {
  const mapEl = document.getElementById(mapElId);
  if (!mapEl) return;

  defaultLat = defaultLat || -7.2504; // fallback: Jawa Timur
  defaultLng = defaultLng || 112.7688;

  const map = L.map(mapElId).setView([defaultLat, defaultLng], 12);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

  function updateInputs(lat, lng) {
    document.getElementById(latInputId).value = lat.toFixed(7);
    document.getElementById(lngInputId).value = lng.toFixed(7);
  }

  marker.on('dragend', function () {
    const pos = marker.getLatLng();
    updateInputs(pos.lat, pos.lng);
  });

  map.on('click', function (e) {
    marker.setLatLng(e.latlng);
    updateInputs(e.latlng.lat, e.latlng.lng);
  });

  // Coba pusatkan ke lokasi user bila input belum pernah diisi (form tambah baru)
  const latInput = document.getElementById(latInputId);
  if (!latInput.value && navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (pos) {
      map.setView([pos.coords.latitude, pos.coords.longitude], 14);
      marker.setLatLng([pos.coords.latitude, pos.coords.longitude]);
      updateInputs(pos.coords.latitude, pos.coords.longitude);
    });
  } else if (latInput.value) {
    updateInputs(parseFloat(latInput.value), parseFloat(document.getElementById(lngInputId).value));
  }
}

/**
 * Render peta read-only (detail produk / profil peternak) dengan satu marker.
 */
function sisapiRenderStaticMap(mapElId, lat, lng, label) {
  const mapEl = document.getElementById(mapElId);
  if (!mapEl || !lat || !lng) return;
  const map = L.map(mapElId).setView([lat, lng], 14);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);
  L.marker([lat, lng]).addTo(map).bindPopup(label || 'Lokasi Ternak').openPopup();
}

/**
 * Tombol navigasi ke lokasi (buka Google Maps direction).
 */
function sisapiNavigateTo(lat, lng) {
  window.open('https://www.google.com/maps/dir/?api=1&destination=' + lat + ',' + lng, '_blank');
}

document.addEventListener('DOMContentLoaded', function () {
  // Preview thumbnail galeri foto produk
  document.querySelectorAll('.detail-thumb-strip img').forEach(function (thumb) {
    thumb.addEventListener('click', function () {
      const mainImg = document.getElementById('main-product-image');
      if (mainImg) mainImg.src = this.dataset.full || this.src;
      document.querySelectorAll('.detail-thumb-strip img').forEach(i => i.classList.remove('active'));
      this.classList.add('active');
    });
  });
});
