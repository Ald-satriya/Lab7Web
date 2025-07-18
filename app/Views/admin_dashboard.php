<?= $this->include('template/admin_header'); ?>

<div class="container py-5 text-light">
  <div class="mb-5 text-center">
    <h2 class="fw-bold text-white"><?= esc($title) ?></h2>
    <p class="text-white-50">Kelola semua konten artikel berita dari satu tempat dengan tampilan yang bersih dan profesional.</p>
  </div>

  <!-- === Kartu Statistik === -->
  <div class="row mb-5 g-4">
    <div class="col-md-6">
      <div class="p-4 bg-success rounded shadow-sm text-center text-white">
        <h4 class="fw-semibold">📄 Total Artikel</h4>
        <p class="fs-1 mb-0"><?= esc($totalArtikel) ?></p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="p-4 bg-info rounded shadow-sm text-center text-white">
        <h4 class="fw-semibold">📁 Total Kategori</h4>
        <p class="fs-1 mb-0"><?= esc($totalKategori) ?></p>
      </div>
    </div>
  </div>

  <!-- === Grafik Artikel per Kategori === -->
  <div class="card bg-dark mb-5 text-white">
    <div class="card-body">
      <h4 class="card-title mb-4">📊 Grafik Artikel per Kategori</h4>
      <canvas id="artikelChart" height="100"></canvas>
    </div>
  </div>

  <!-- === Daftar Artikel Terbaru === -->
  <div class="card bg-dark text-white">
    <div class="card-body">
      <h4 class="card-title mb-3">🕒 Artikel Terbaru</h4>
      <ul class="list-group list-group-flush">
        <?php foreach ($artikelTerbaru as $a): ?>
          <li class="list-group-item bg-transparent text-white border-secondary">
            <strong>📰 <?= esc($a['judul']) ?></strong><br>
            <small class="text-light">🗓 <?= date('d M Y H:i', strtotime($a['created_at'])) ?></small>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>

<!-- === Chart JS & Label di atas Bar === -->
<script>
  Chart.register(ChartDataLabels); // Aktifkan plugin

  const ctx = document.getElementById('artikelChart').getContext('2d');
  const artikelChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_column($artikelPerKategori, 'nama_kategori')) ?>,
      datasets: [{
        label: 'Jumlah Artikel per Kategori',
        data: <?= json_encode(array_column($artikelPerKategori, 'jumlah')) ?>,
        backgroundColor: '#10b981'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: true,
          labels: { color: '#ffffff' }
        },
        tooltip: {
          backgroundColor: '#1f2937',
          titleColor: '#ffffff',
          bodyColor: '#ffffff'
        },
        datalabels: {
          anchor: 'end',
          align: 'top',
          color: '#ffffff',
          font: {
            weight: 'bold',
            size: 14
          }
        }
      },
      scales: {
        x: {
          ticks: { color: '#ffffff' },
          grid: { display: false }
        },
        y: {
          beginAtZero: true,
          ticks: { color: '#ffffff' },
          grid: { color: '#374151' }
        }
      }
    },
    plugins: [ChartDataLabels]
  });
</script>


<?= $this->include('template/admin_footer'); ?>