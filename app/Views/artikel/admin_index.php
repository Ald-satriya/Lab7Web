<?= $this->include('template/admin_header'); ?>

<div class="container my-4">
    <h2><?= $title ?? 'Manajemen Artikel' ?></h2>

    <form id="search-form" method="get" class="form-search mb-4">
        <div class="row g-2">
            <div class="col-md-5">
                <input type="text" name="q" id="search-box" placeholder="Cari Judul Artikel" class="form-control" value="<?= esc($q ?? '') ?>">
            </div>
            <div class="col-md-4">
                <select name="kategori_id" id="kategori-filter" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= esc($k['id_kategori']) ?>" <?= (isset($kategori_id) && $kategori_id == $k['id_kategori']) ? 'selected' : '' ?>>
                            <?= esc($k['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
            </div>
        </div>
    </form>

    <hr>

    <a href="<?= base_url('admin/artikel/add') ?>" class="btn btn-success mb-3">Tambah Artikel Baru</a>

    <div id="loading-spinner" class="text-center my-4" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="article-container">
        </div>

    <div class="d-flex justify-content-center mt-3" id="pagination-container">
        </div>
</div>

<?= $this->include('template/admin_footer'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
<<<<<<< HEAD
    /**
     * Mengambil dan menampilkan data artikel via AJAX.
     * @param {string} url URL untuk permintaan AJAX (misal: '/admin/artikel' atau '/admin/artikel?page=2')
     */
    function fetchData(url) {
        // Sembunyikan konten dan tampilkan spinner loading
=======
    function fetchData(url = '/admin/artikel') {
        const q = $('#search-box').val();
        const kategori_id = $('#kategori-filter').val();

>>>>>>> 0e864c0 (Praktikum 10 : Update API with Improvisasi)
        $('#article-container').hide();
        $('#pagination-container').hide();
        $('#loading-spinner').show();

        // Ambil nilai filter saat ini dari input form yang terlihat di halaman
        const currentQ = $('#search-box').val();
        const currentKategoriId = $('#kategori-filter').val();

        // Buat objek URL dari URL yang diterima (bisa URL baru atau URL pagination)
        const urlObj = new URL(url, window.location.origin); 
        
        // Tambahkan atau perbarui parameter filter ke URL objek
        // Ini memastikan filter tetap aktif saat berpindah halaman pagination
        if (currentQ) {
            urlObj.searchParams.set('q', currentQ);
        } else {
            urlObj.searchParams.delete('q'); // Hapus parameter jika nilai kosong
        }

        if (currentKategoriId) {
            urlObj.searchParams.set('kategori_id', currentKategoriId);
        } else {
            urlObj.searchParams.delete('kategori_id'); // Hapus parameter jika nilai kosong
        }

        $.ajax({
            url: urlObj.toString(), // Gunakan URL yang sudah diperbarui dengan parameter filter
            type: 'GET',
<<<<<<< HEAD
            dataType: 'json', // Harap respons dari server adalah JSON
            headers: { 'X-Requested-With': 'XMLHttpRequest' }, // Header ini menandakan permintaan AJAX ke CodeIgniter
            success: function(response) {
                // Pastikan struktur respons sesuai yang diharapkan
                if (response && response.artikel && response.pager && response.pager.links) {
                    renderArticles(response.artikel);
                    $('#pagination-container').html(response.pager.links);

                    // Opsional: Perbarui URL di browser tanpa reload penuh
                    window.history.pushState({}, '', urlObj.toString());

                } else {
                    $('#article-container').html('<p class="text-danger text-center">Format data tidak valid dari server.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error, xhr.responseText);
                $('#article-container').html('<p class="text-danger text-center">Gagal memuat data. Silakan coba lagi.</p>');
=======
            dataType: 'json',
            data: {
                q: q,
                kategori_id: kategori_id
            },
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(data) {
                renderArticles(data.artikel);
                $('#pagination-container').html(data.pager.links);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $('#article-container').html('<p class="text-danger text-center">Gagal memuat data.</p>');
>>>>>>> 0e864c0 (Praktikum 10 : Update API with Improvisasi)
            },
            complete: function() {
                $('#loading-spinner').hide();
                $('#article-container').show();
                $('#pagination-container').show();
            }
        });
    }

    /**
     * Membangun HTML tabel artikel dari data JSON yang diterima.
     * @param {Array} artikel Array objek artikel dari respons server.
     */
    function renderArticles(artikel) {
        let html = '<div class="table-responsive"><table class="table table-bordered table-striped">';
        html += '<thead><tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead><tbody>';

        if (artikel.length > 0) {
            artikel.forEach(row => {
                const statusBadgeClass = row.status == 1 ? 'bg-success' : 'bg-secondary';
                const statusText = row.status == 1 ? 'Published' : 'Draft';
                const artikelIsiSnippet = row.isi ? row.isi.substring(0, 50) + '...' : '';

                html += `<tr>
                    <td>${row.id}</td>
                    <td><b>${row.judul}</b><p><small>${artikelIsiSnippet}</small></p></td>
                    <td>${row.nama_kategori || '-'}</td>
                    <td><span class="badge ${statusBadgeClass}">${statusText}</span></td>
                    <td>
                        <a href="<?= base_url('admin/artikel/edit/') ?>${row.id}" class="btn btn-warning btn-sm">Ubah</a>
                        <a href="<?= base_url('admin/artikel/delete/') ?>${row.id}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?');">Hapus</a>
                    </td>
                </tr>`;
            });
        } else {
            html += '<tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>';
        }

        html += '</tbody></table></div>';
        $('#article-container').html(html);
    }

    // --- Event Listeners ---

    // 1. Ketika form pencarian/filter di-submit
    $('#search-form').on('submit', function(e) {
<<<<<<< HEAD
        e.preventDefault(); 
        fetchData('<?= base_url('admin/artikel') ?>'); // Panggil fetchData untuk memuat ulang data dengan filter
=======
        e.preventDefault();
        fetchData();
>>>>>>> 0e864c0 (Praktikum 10 : Update API with Improvisasi)
    });

    // 2. Ketika filter kategori diubah (change event)
    $('#kategori-filter').on('change', function() {
        $('#search-form').trigger('submit'); // Trigger submit form untuk memanggil fetchData
    });

<<<<<<< HEAD
    // 3. Ketika tautan pagination diklik (Delegasi event karena tautan dimuat dinamis)
    $(document).on('click', '#pagination-container .page-link', function(e) {
        e.preventDefault(); 
        const url = $(this).attr('href'); 
        console.log('Pagination link clicked! URL:', url); // BARIS DEBUGGING: Cek apakah event terpanggil
        fetchData(url); 
    });

    // --- Load Data Pertama Kali ---
    fetchData('<?= base_url('admin/artikel') ?>');
=======
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url) fetchData(url);
    });

    fetchData();
>>>>>>> 0e864c0 (Praktikum 10 : Update API with Improvisasi)
});
</script>

<style>
    .form-search input,
    .form-search select {
        border-radius: 5px;
    }

    .form-search button {
        border-radius: 5px;
    }

    .table th {
        background-color: #f8f9fa;
    }

    .pagination a {
        color: #2575fc;
        text-decoration: none;
    }

    .pagination .active .page-link {
        background-color: #2575fc;
        color: white;
        border-color: #2575fc;
    }

    .pagination .page-link:hover {
        color: #6a11cb;
    }

    .btn-warning {
        background-color: #ff9800;
        border: none;
    }

    .btn-danger {
        background-color: #f44336;
        border: none;
    }

    .btn-warning:hover {
        background-color: #e68900;
    }

    .btn-danger:hover {
        background-color: #c4322a;
    }

    #loading-spinner .spinner-border {
        width: 3rem;
        height: 3rem;
    }
</style>