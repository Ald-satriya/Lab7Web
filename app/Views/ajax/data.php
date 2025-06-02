<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($artikel)): ?>
                <?php foreach ($artikel as $row): ?>
                <tr>
                    <td class="text-center"><?= esc($row['id']) ?></td>
                    <td><?= esc($row['judul']) ?></td>
                    <td><?= esc($row['nama_kategori'] ?? '-') ?></td>
                    <td class="text-center">
                        <span class="badge bg-<?= $row['status'] == 1 ? 'success' : 'secondary' ?>">
                            <?= $row['status'] == 1 ? 'Published' : 'Draft' ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning btn-edit" data-id="<?= esc($row['id']) ?>">Ubah</button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="<?= esc($row['id']) ?>">Hapus</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data artikel yang ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div id="pagination" class="d-flex justify-content-center mt-3">
    <?= $pager->makeLinks(
        $pager->getCurrentPage('artikel'),
        $pager->getPerPage('artikel'),
        $pager->getTotal('artikel'),
        'bootstrap', // Nama template pager (default: 'default_full', 'bootstrap', atau template kustom Anda)
        'artikel',   // Nama grup pager
        ['previous' => '❮', 'next' => '❯'] // Opsi untuk mengubah teks tombol
    ) ?>
</div>