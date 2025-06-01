<tbody>
<?php foreach ($artikel as $row): ?>
<tr>
    <td class="text-center"><?= $row['id'] ?></td>
    <td><?= $row['judul'] ?></td>
    <td><?= $row['nama_kategori'] ?? '-' ?></td>
    <td class="text-center">
        <span class="badge bg-<?= $row['status'] == 1 ? 'success' : 'secondary' ?>">
            <?= $row['status'] == 1 ? 'Published' : 'Draft' ?>
        </span>
    </td>
    <td class="text-center">
        <button class="btn btn-sm btn-warning btn-edit" data-id="<?= $row['id'] ?>">Ubah</button>
        <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $row['id'] ?>">Hapus</button>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<!-- ✅ Pusatkan pagination -->
<div id="pagination" class="d-flex justify-content-center mt-3">
    <?= $pager->links('artikel', 'bootstrap') ?>
</div>
