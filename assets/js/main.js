// ===== SISAPI main.js =====

// Autocomplete pencarian ternak di landing page
(function () {
  const input = document.getElementById('autocompleteSearch');
  const box = document.getElementById('autocompleteBox');
  if (!input || !box) return;

  let timer = null;
  input.addEventListener('input', function () {
    clearTimeout(timer);
    const q = this.value.trim();
    box.innerHTML = '';
    if (q.length < 2) return;

    timer = setTimeout(() => {
      fetch(BASE_URL + 'cari/autocomplete?q=' + encodeURIComponent(q))
        .then(r => r.json())
        .then(data => {
          box.innerHTML = '';
          data.forEach(item => {
            const a = document.createElement('a');
            a.href = BASE_URL + 'produk/' + item.slug;
            a.className = 'list-group-item list-group-item-action';
            a.textContent = item.nama_ternak;
            box.appendChild(a);
          });
        });
    }, 300);
  });

  document.addEventListener('click', function (e) {
    if (!box.contains(e.target) && e.target !== input) box.innerHTML = '';
  });
})();

// Toggle favorit (placeholder - lihat roadmap fitur wishlist)
document.addEventListener('click', function (e) {
  if (e.target.closest('#btnFavorit')) {
    const btn = e.target.closest('#btnFavorit');
    const icon = btn.querySelector('i');
    icon.classList.toggle('bi-heart');
    icon.classList.toggle('bi-heart-fill');
    icon.classList.toggle('text-danger');
    // TODO: kirim request AJAX ke endpoint favorit/toggle setelah fitur wishlist diimplementasikan
  }
});
