<?= $this->include('template/admin_header'); ?>

<div class="container my-4">
    <h1 class="mb-4">Artikel List</h1>

    <!-- Search Form -->
    <form method="get" class="form-search mb-4">
        <div class="input-group">
            <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari data" class="form-control">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <!-- Artikel Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($artikel): foreach ($artikel as $row): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td>
                            <b><?= $row['judul']; ?></b>
                            <p><small><?= substr($row['isi'], 0, 50); ?>...</small></p>
                        </td>
                        <td><?= $row['status']; ?></td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="<?= base_url('/admin/artikel/edit/' . $row['id']); ?>">Ubah</a>
                            <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']); ?>">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        <?= $pager->only(['q'])->links(); ?>
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
        text-align: center;
    }

    .form-search input {
        border-radius: 5px 0 0 5px;
        box-shadow: none;
    }

    .form-search button {
        border-radius: 0 5px 5px 0;
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
