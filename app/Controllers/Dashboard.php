<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $artikelModel = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        $data = [
            'title' => 'Dashboard Admin',
            'totalArtikel' => $artikelModel->countAll(),
            'totalKategori' => $kategoriModel->countAll(),
            'totalAdmin' => 1, // ganti dengan perhitungan admin user sebenarnya
            'artikelTerbaru' => $artikelModel->orderBy('created_at', 'DESC')->limit(5)->findAll()
        ];

        return view('artikel/admin_dashboard', $data);
    }
}