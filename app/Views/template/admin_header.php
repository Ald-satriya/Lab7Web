<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Admin Portal'; ?></title>

    <!-- Bootstrap dan Chart.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <style>
        /* Tema Galaxy */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0d1b2a, #1b263b, #415a77);
            color: #fff;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-attachment: fixed;
        }

        .stars {
            position: fixed;
            width: 100%;
            height: 100%;
            background: transparent url('https://www.transparenttextures.com/patterns/stardust.png') repeat top center;
            opacity: 0.2;
            z-index: -1;
            animation: twinkling 60s infinite linear;
        }

        @keyframes twinkling {
            from { background-position: 0 0; }
            to { background-position: -10000px 5000px; }
        }

        .header {
            padding: 30px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            background: linear-gradient(to right, #4cc9f0, #4361ee, #3a0ca3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.2);
        }

        .navbar {
            display: flex;
            background: linear-gradient(to right, #1f1c2c, #928dab);
            padding: 12px 0;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .navbar a {
            color: #ffffff;
            padding: 14px 24px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .navbar a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
        }

        .container {
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            margin: 30px auto;
            max-width: 1000px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        footer {
            background: #0d1b2a;
            color: #aaa;
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            border-top: 1px solid #1b263b;
        }
    </style>
</head>
<body>

    <div class="stars"></div> <!-- Efek bintang Galaxy -->

    <div class="header">
        📰 Admin Portal Berita
    </div>

    <div class="navbar">
        <a href="<?= base_url('/admin/dashboard'); ?>">Dashboard</a>
        <a href="<?= base_url('/admin/artikel'); ?>">Artikel</a>
        <a href="<?= base_url('/admin/artikel/add'); ?>">Tambah Artikel</a>
    </div>

    <div class="container">
        <!-- Konten admin portal akan ditampilkan di sini -->
        <p>Selamat datang di Admin Portal Berita bertema Galaxy. Gunakan navigasi di atas untuk mengelola konten.</p>
    </div>

    <footer>
        &copy; <?= date('Y'); ?> Admin Portal Berita - Galaxy Theme by Midori
    </footer>

</body>
</html>
