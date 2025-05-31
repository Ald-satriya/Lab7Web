<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Admin Portal'; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .header {
            padding: 30px;
            text-align: center;
            font-size: 32px;
            font-weight: 600;
            color: #444;
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .navbar-custom {
            background-color: #1f74cc;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .navbar-custom a {
            color: white;
            font-weight: 500;
            padding: 12px 18px;
            text-decoration: none;
        }

        .navbar-custom a:hover {
            background-color: #155fa0;
            color: #fff;
        }

        .container {
            padding: 25px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-top: 30px;
        }

        footer {
            background: #222;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            font-size: 14px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    Admin Portal Berita
</div>

<!-- Navbar -->
<div class="navbar navbar-custom d-flex justify-content-center">
    <a href="<?= base_url('/admin/artikel'); ?>">Dashboard</a>
    <a href="<?= base_url('/admin/artikel'); ?>">Artikel</a>
    <a href="<?= base_url('/admin/artikel/add'); ?>">Tambah Artikel</a>
</div>

<!-- Main Content -->
<div class="container">
