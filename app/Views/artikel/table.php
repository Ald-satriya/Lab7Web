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
    </table>
</div>

<div class="d-flex justify-content-center mt-3">
    <?= $pager->only(['q', 'kategori_id'])->links(); ?>
</div>
