<?= $this->include('template/admin_header'); ?>

<div class="container my-4">
    <!-- Search & Filter Form -->
    <form id="search-form" method="get" class="form-search mb-4">
        <div class="row g-2">
            <div class="col-md-5">
                <input type="text" name="q" id="search-box" placeholder="Cari data" class="form-control">
            </div>
            <div class="col-md-4">
                <select name="kategori_id" id="kategori-filter" class="form-control">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </div>
    </form>

    <!-- Spinner Loading -->
    <div id="loading-spinner" class="text-center my-4" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Kontainer Artikel -->
    <div id="article-container">
        <!-- Akan diisi via AJAX -->
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3" id="pagination-container">
        <!-- Akan diisi via AJAX -->
    </div>
</div>

<?= $this->include('template/admin_footer'); ?>

<!-- jQuery untuk AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function fetchData(url = '/admin/artikel') {
            const q = $('#search-box').val();
            const kategori_id = $('#kategori-filter').val();

            $('#article-container').hide();
            $('#pagination-container').hide();
            $('#loading-spinner').show();

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data: {
                    q: q,
                    kategori_id: kategori_id
                },
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    renderArticles(data.artikel);
                    $('#pagination-container').html(data.pager.links);
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    $('#article-container').html('<p class="text-danger text-center">Gagal memuat data.</p>');
                },
                complete: function () {
                    $('#loading-spinner').hide();
                    $('#article-container').show();
                    $('#pagination-container').show();
                }
            });
        }

        function renderArticles(artikel) {
            let html = '<div class="table-responsive"><table class="table table-bordered table-striped">';
            html += '<thead><tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Gambar</th><th>Status</th><th>Aksi</th></tr></thead><tbody>';

            if (artikel.length > 0) {
                artikel.forEach(row => {
                    html += `<tr>
                        <td>${row.id}</td>
                        <td><b>${row.judul}</b><p><small>${row.isi.substring(0, 50)}...</small></p></td>
                        <td>${row.nama_kategori || '-'}</td>
                        <td>
                            ${row.gambar ? `<img src="/gambar/${row.gambar}" alt="gambar" style="width: 70px; height: auto; border-radius: 6px;">` : '-'}
                        </td>
                        <td>${row.status}</td>
                        <td>
                            <a href="/admin/artikel/edit/${row.id}" class="btn btn-warning btn-sm">Ubah</a>
                            <a href="/admin/artikel/delete/${row.id}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?');">Hapus</a>
                        </td>
                    </tr>`;
                });
            } else {
                html += '<tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>';
            }

            html += '</tbody></table></div>';
            $('#article-container').html(html);
        }

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            fetchData();
        });

        $('#kategori-filter').on('change', function () {
            $('#search-form').trigger('submit');
        });

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url) fetchData(url);
        });

        fetchData();
    });
</script>

<!-- CSS Styling -->
<style>
    body {
        background-color: #1f2d3d;
        color: #ecf0f1;
    }

    .table th:last-child,
    .table td:last-child {
        width: 160px;
        white-space: nowrap;
    }

    .table th:nth-child(3),
    .table td:nth-child(3) {
        width: 160px;
        white-space: nowrap;
    }

    .table th:nth-child(4),
    .table td:nth-child(4) {
        width: 200px;
        text-align: center;
    }

    .table th:nth-child(5),
    .table td:nth-child(5) {
        width: 100px;
        text-align: center;
    }

    .table th:nth-child(6),
    .table td:nth-child(6) {
        width: 180px;
    }

    .form-search input,
    .form-search select {
        border-radius: 8px;
        background-color: #2e3c4f;
        color: #ecf0f1;
        border: 1px solid #3f4c5c;
    }

    .form-search input::placeholder {
        color: #b0bec5;
    }

    .form-search select {
        background-image: none;
    }

    .form-search button {
        border-radius: 8px;
        background: linear-gradient(135deg, #1abc9c, #16a085);
        border: none;
        color: #fff;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .form-search button:hover {
        background: linear-gradient(135deg, #16a085, #1abc9c);
    }

    .table {
        background-color: #2c3e50;
        color: #ecf0f1;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 10px;
        overflow: hidden;
    }

    .table th {
        background-color: #34495e;
        color: #1abc9c;
        font-weight: 600;
        border: none;
    }

    .table td {
        border-color: #3f4c5c;
        background-color: #2f4157;
        color: #ecf0f1;
    }

    .table tbody tr:hover {
        background-color: #3b556f;
        transition: background 0.3s ease;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f39c12, #e67e22);
        color: white;
        font-weight: 600;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        transition: background 0.3s ease;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #e67e22, #f39c12);
    }

    .btn-danger {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        font-weight: 600;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        transition: background 0.3s ease;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #c0392b, #e74c3c);
    }

    .pagination .page-link {
        background-color: #2c3e50;
        color: #1abc9c;
        border: 1px solid #3f4c5c;
        border-radius: 6px;
    }

    .pagination .active .page-link {
        background-color: #1abc9c;
        color: #fff;
        border-color: #1abc9c;
    }

    .pagination .page-link:hover {
        background-color: #16a085;
        color: white;
    }

    #loading-spinner .spinner-border {
        width: 3rem;
        height: 3rem;
        color: #1abc9c;
    }
</style>
