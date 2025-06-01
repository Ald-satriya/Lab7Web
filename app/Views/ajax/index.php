<?= $this->include('template/header'); ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>📄 Data Artikel (AJAX)</h4>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Artikel</button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="artikelTable">
            <thead class="table-primary text-center">
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Pagination akan dimasukkan di sini -->
    <div id="pagination" class="d-flex justify-content-center mt-3"></div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <form id="formTambah" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Artikel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="judul" class="form-label">Judul</label>
          <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="isi" class="form-label">Isi</label>
          <textarea name="isi" class="form-control" rows="4" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog">
    <form id="formEdit" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Artikel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit-id">
        <div class="mb-3">
          <label for="edit-judul" class="form-label">Judul</label>
          <input type="text" name="judul" id="edit-judul" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="edit-isi" class="form-label">Isi</label>
          <textarea name="isi" id="edit-isi" class="form-control" rows="4" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Update</button>
      </div>
    </form>
  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    function loadData(page = 1) {
        $.get("<?= base_url('ajax/get') ?>", { page }, function (html) {
            $('#artikelTable tbody').remove(); // hapus tbody lama
            $('#artikelTable').append($(html).find('tbody')); // tambah tbody baru
            $('#pagination').html($(html).find('#pagination').html()); // replace pagination
        });
    }

    loadData(); // initial load

    // 🔧 Perbaikan klik pagination — gunakan class Bootstrap `.page-link`
    $(document).on('click', '#pagination .page-link', function (e) {
        e.preventDefault();
        const page = $(this).attr('href').split('page=')[1];
        loadData(page);
    });

    // Tambah Artikel
    $('#formTambah').submit(function (e) {
        e.preventDefault();
        $.post("<?= base_url('ajax/save') ?>", $(this).serialize(), function (res) {
            if (res.status === 'OK') {
                bootstrap.Modal.getInstance(document.getElementById('modalTambah')).hide();
                $('#formTambah')[0].reset();
                loadData();
            } else {
                alert(res.message);
            }
        }, 'json');
    });

    // Edit Artikel
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        $.get("<?= base_url('ajax/edit/') ?>" + id, function (data) {
            $('#edit-id').val(data.id);
            $('#edit-judul').val(data.judul);
            $('#edit-isi').val(data.isi);
            new bootstrap.Modal(document.getElementById('modalEdit')).show();
        }, 'json');
    });

    // Submit Edit
    $('#formEdit').submit(function (e) {
        e.preventDefault();
        const id = $('#edit-id').val();
        $.post("<?= base_url('ajax/update/') ?>" + id, $(this).serialize(), function (res) {
            if (res.status === 'OK') {
                bootstrap.Modal.getInstance(document.getElementById('modalEdit')).hide();
                loadData();
            } else {
                alert(res.message);
            }
        }, 'json');
    });

    // Hapus Artikel
    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        if (confirm('Yakin ingin menghapus artikel ini?')) {
            $.ajax({
                url: "<?= base_url('ajax/delete/') ?>" + id,
                type: "DELETE",
                success: function (res) {
                    if (res.status === 'OK') loadData();
                    else alert(res.message);
                }
            });
        }
    });
});
</script>

<?= $this->include('template/footer'); ?>
