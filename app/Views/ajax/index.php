<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Portal Berita' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Beberapa styling tambahan jika diperlukan */
        .badge {
            font-size: 0.8em;
            padding: 0.3em 0.6em;
            border-radius: 0.25rem;
        }
        .badge.bg-success { background-color: #28a745 !important; color: white; }
        .badge.bg-secondary { background-color: #6c757d !important; color: white; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Portal Berita</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tambah Artikel</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Data Artikel</h2>

        <div class="row mb-3 align-items-end">
            <div class="col-md-4">
                <label for="inputCari" class="form-label">Cari Judul:</label>
                <input type="text" id="inputCari" class="form-control" placeholder="Masukkan kata kunci judul">
            </div>
            <div class="col-md-4">
                <label for="filterKategori" class="form-label">Filter Kategori:</label>
                <select id="filterKategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php
                    // Pastikan $kategori_list ada dan di-pass dari controller (jika index() juga menampilkan ini)
                    // Atau pastikan KategoriModel diinisialisasi di sini jika Anda tidak melewatkannya dari controller
                    $kategoriModel = new App\Models\KategoriModel();
                    $kategori_list = $kategoriModel->findAll();
                    foreach ($kategori_list as $kategori): ?>
                        <option value="<?= esc($kategori['id']) ?>"><?= esc($kategori['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <button id="btnCari" class="btn btn-primary">Terapkan Filter</button>
            </div>
        </div>

        <hr>

        <button class="btn btn-success mb-3" id="btnAddArtikel">Tambah Artikel Baru</button>

        <div id="data-container">
            <p>Memuat data artikel...</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi untuk memuat data artikel
        function loadArtikel(page = 1, kategori = '', cari = '') {
            $.ajax({
                url: '<?= base_url('ajax/get') ?>', // Menggunakan base_url() helper PHP
                method: 'GET',
                data: {
                    page: page,
                    kategori: kategori,
                    cari: cari
                },
                success: function(response) {
                    // Masukkan HTML respons ke dalam div container
                    $('#data-container').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading articles:", error);
                    alert("Gagal memuat data artikel. Silakan coba lagi.");
                }
            });
        }

        // Panggil fungsi loadArtikel() pertama kali saat halaman dimuat
        $(document).ready(function() {
            // Ambil nilai filter awal jika ada di URL saat halaman dimuat
            const urlParams = new URLSearchParams(window.location.search);
            const initialPage = urlParams.get('page') || 1;
            const initialKategori = urlParams.get('kategori') || '';
            const initialCari = urlParams.get('cari') || '';

            // Set nilai filter di UI
            $('#filterKategori').val(initialKategori);
            $('#inputCari').val(initialCari);

            // Muat data artikel dengan filter awal
            loadArtikel(initialPage, initialKategori, initialCari);
        });

        // Event listener untuk klik tautan pagination
        // Menggunakan event delegation karena tautan pagination dimuat secara dinamis
        $(document).on('click', '#pagination .pagination li a', function(e) {
            e.preventDefault(); // Mencegah perilaku default (reload halaman)

            var href = $(this).attr('href');
            // Pastikan href memiliki query string sebelum mencoba split
            if (href && href.includes('?')) {
                var urlParams = new URLSearchParams(href.split('?')[1]);
                var page = urlParams.get('page'); // Ambil nilai parameter 'page'
            } else {
                // Jika href tidak memiliki query string (misal, klik 'Previous' atau 'Next' di halaman 1)
                // maka diasumsikan ini adalah link ke halaman saat ini.
                // Anda mungkin perlu logika yang lebih kompleks di sini jika router CI Anda tidak selalu menggunakan ?page=X
                var page = 1; // Default ke halaman 1 jika tidak ada page param
            }

            // Ambil nilai filter dan pencarian yang sedang aktif di UI
            var currentKategori = $('#filterKategori').val();
            var currentCari = $('#inputCari').val();

            // Muat ulang data artikel dengan nomor halaman dan filter yang baru
            loadArtikel(page, currentKategori, currentCari);
        });

        // Event listener untuk perubahan pada dropdown filter kategori
        $(document).on('change', '#filterKategori', function() {
            var kategori = $(this).val();
            var cari = $('#inputCari').val();
            loadArtikel(1, kategori, cari); // Kembali ke halaman 1 saat filter kategori berubah
        });

        // Event listener untuk klik tombol 'Terapkan Filter' (pencarian)
        $(document).on('click', '#btnCari', function() {
            var kategori = $('#filterKategori').val();
            var cari = $('#inputCari').val();
            loadArtikel(1, kategori, cari); // Kembali ke halaman 1 saat pencarian baru dilakukan
        });

        // Anda juga bisa menambahkan event listener untuk input pencarian (misal, saat 'Enter' ditekan)
        $(document).on('keypress', '#inputCari', function(e) {
            if (e.which == 13) { // Key code 13 adalah Enter
                $('#btnCari').click(); // Simulasikan klik tombol cari
            }
        });

        // --- Contoh Event Listener untuk Tombol Ubah dan Hapus (modal/form AJAX) ---
        // Anda harus sudah memiliki modal untuk edit/form untuk tambah di index.php atau layout utama
        // dan fungsi JavaScript yang sesuai (misal: showEditModal, confirmDelete)

        // $(document).on('click', '.btn-edit', function() {
        //     var id = $(this).data('id');
        //     // Panggil fungsi untuk menampilkan modal edit dan mengisi datanya
        //     // Misalnya: showEditModal(id);
        // });

        // $(document).on('click', '.btn-delete', function() {
        //     var id = $(this).data('id');
        //     // Panggil fungsi untuk konfirmasi hapus dan mengirim permintaan delete via AJAX
        //     // Misalnya: confirmDelete(id);
        // });

        // $(document).on('click', '#btnAddArtikel', function() {
        //     // Panggil fungsi untuk menampilkan modal tambah artikel
        //     // Misalnya: showAddModal();
        // });

    </script>
</body>
</html>