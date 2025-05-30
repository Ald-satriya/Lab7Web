<?= $this->include('template/admin_header'); ?>

<div class="container my-4">
    <!-- Search & Filter Form -->
    <form method="get" class="form-search mb-4">
        <div class="row g-2">
            <div class="col-md-5">
                <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari data" class="form-control">
            </div>
            <div class="col-md-4">
                <select name="kategori_id" class="form-control">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id_kategori']; ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                            <?= $k['nama_kategori']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </div>
    </form>

    <!-- Artikel Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if($artikel): foreach($artikel as $row): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td>
                            <b><?= $row['judul']; ?></b>
                            <p><small><?= substr($row['isi'], 0, 50); ?>...</small></p>
                        </td>
                        <td><?= $row['nama_kategori'] ?? '-'; ?></td>
                        <td><?= $row['status']; ?></td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="<?= base_url('/admin/artikel/edit/' . $row['id']); ?>">Ubah</a>
                            <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']); ?>">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        <?= $pager->only(['q', 'kategori_id'])->links(); ?>
    </div>
</div>

<?= $this->include('template/admin_footer'); ?>

<!-- CSS Styling -->
<style>
    body {
        background-color: #f7f7f7;
        font-family: 'Arial', sans-serif;
    }

    .container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    h1 {
        font-size: 1.75rem;
        color: #333;
    }

    .form-search input,
    .form-search select {
        border-radius: 5px;
        box-shadow: none;
    }

    .form-search button {
        border-radius: 5px;
        background-color: #2575fc;
        color: white;
    }

    .form-search button:hover {
        background-color: #6a11cb;
    }

    .table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    .table th, .table td {
        padding: 12px;
        text-align: left;
    }

    .table th {
        background-color: #f2f2f2;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #fafafa;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 0.875rem;
    }

    .btn-warning {
        background-color: #ff9800;
    }

    .btn-warning:hover {
        background-color: #e68900;
    }

    .btn-danger {
        background-color: #f44336;
    }

    .btn-danger:hover {
        background-color: #e53935;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .d-flex {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination a {
        color: #2575fc;
        text-decoration: none;
    }

    .pagination a:hover {
        color: #6a11cb;
    }

    .pagination .active a {
        background-color: #2575fc;
        color: white;
    }
</style>
