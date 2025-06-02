<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel; // Pastikan ini di-import
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    protected $helpers = ['form', 'url', 'text']; // 'text' diperlukan untuk url_title()

    // Method default untuk halaman artikel frontend (jika ada)
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->getArtikelDenganKategori(); // Menggunakan method dari model

        return view('artikel/index', compact('artikel', 'title'));
    }

    // Method untuk menampilkan detail artikel frontend
    public function view($slug)
    {
        $model = new ArtikelModel();
        $artikel = $model->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                         ->select('artikel.*, kategori.nama_kategori')
                         ->where('slug', $slug)
                         ->get()
                         ->getRowArray();

        if (!$artikel) {
            throw PageNotFoundException::forPageNotFound();
        }

        $title = $artikel['judul'];
        return view('artikel/detail', compact('artikel', 'title'));
    }

    /**
     * Method ini menangani halaman admin artikel, termasuk pagination dan filter via AJAX.
     * Dipanggil oleh rute 'admin/artikel'.
     */
    public function admin_index()
    {
        // Ambil parameter pencarian ('q') dan filter kategori ('kategori_id') dari URL
        $q = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? ''; // Pastikan nama parameter sesuai

        // Inisialisasi model
        $artikelModel = new ArtikelModel();
        $kategoriModel = new KategoriModel(); // Model untuk daftar kategori

        // Inisialisasi query builder untuk artikel dengan join ke kategori
        $builder = $artikelModel->select('artikel.*, kategori.nama_kategori')
                                ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');
                                // ^^ PASTIKAN 'kategori.id_kategori' BENAR SESUAI PRIMARY KEY TABLE KATEGORI ANDA

        // Terapkan filter pencarian judul jika 'q' tidak kosong
        if (!empty($q)) {
            $builder->like('artikel.judul', $q);
        }

        // Terapkan filter kategori jika 'kategori_id' tidak kosong
        if (!empty($kategori_id)) {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        // --- PERBAIKAN: ORDER BY dan Jumlah Data Per Halaman ---
        // Penting: Urutkan hasil untuk konsistensi pagination
        $builder->orderBy('artikel.id', 'DESC'); // Mengurutkan dari artikel terbaru

        // Atur jumlah item per halaman menjadi 5
        $perPage = 5;

        // Dapatkan data artikel yang sudah dipaginasi
        // Parameter 'default' adalah nama grup pagination
        $artikel = $builder->paginate($perPage, 'default');
        $pager = $artikelModel->pager; // Dapatkan objek pager dari model

        // --- Logika Khusus Untuk Permintaan AJAX ---
        // Jika request datang dari AJAX (ditandai dengan header X-Requested-With)
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'artikel' => $artikel, // Data artikel untuk ditampilkan
                'pager' => [
                    'links' => $pager->links('default', 'bootstrap') // Tautan pagination dalam format HTML
                    // 'currentPage' => $pager->getCurrentPage('default'), // Tambahkan info pager lain jika perlu
                    // 'perPage' => $pager->getPerPage('default'),
                    // 'total' => $pager->getTotal('default'),
                ]
            ]);
        }

        // --- Logika Untuk Permintaan Non-AJAX (Initial Load) ---
        // Ini akan dieksekusi saat halaman pertama kali dimuat (tanpa AJAX)
        // JavaScript di view akan mengambil alih dan memuat data via AJAX setelah ini.
        return view('artikel/admin_index', [
            'artikel' => $artikel, // Data ini bisa kosong atau berisi data pertama
            'pager' => $pager,     // Pager object (digunakan oleh JS untuk generate URL pagination)
            'q' => $q, // Untuk mengisi kembali nilai pencarian di form
            'kategori_id' => $kategori_id, // Untuk membuat opsi kategori terpilih di dropdown
            'kategori' => $kategoriModel->findAll(), // Daftar semua kategori untuk dropdown filter
            'title' => 'Manajemen Artikel'
        ]);
    }

    // Method untuk menambahkan artikel baru
    public function add()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required|min_length[3]',
            'id_kategori' => 'required|integer', // Sesuaikan jika nama kolom kategori Anda berbeda
            'isi' => 'required'
        ]);

        if ($this->request->getMethod() === 'post' && $validation->withRequest($this->request)->run()) {
            $file = $this->request->getFile('gambar');
            $namaGambar = null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Pastikan direktori 'public/gambar' ada dan writable
                $file->move(ROOTPATH . 'public/gambar', $file->getRandomName()); // Gunakan getRandomName()
                $namaGambar = $file->getName();
            }

            $artikel = new ArtikelModel();
            $artikel->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul'), '-', true),
                'id_kategori' => $this->request->getPost('id_kategori'), // Sesuaikan jika nama kolom kategori Anda berbeda
                'gambar' => $namaGambar,
                'status' => 1 // Misal: 1 untuk published, 0 untuk draft
            ]);

            return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil ditambahkan.');
        }

        $kategoriModel = new KategoriModel();
        return view('artikel/form_add', [
            'title' => 'Tambah Artikel',
            'kategori' => $kategoriModel->findAll(),
            'validation' => $validation
        ]);
    }

    // Method untuk mengedit artikel
    public function edit($id = null)
    {
        $artikelModel = new ArtikelModel();
        $artikelData = $artikelModel->find($id);

        if (!$artikelData) {
            throw PageNotFoundException::forPageNotFound('Artikel dengan ID: ' . $id . ' tidak ditemukan.');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required|min_length[3]',
            'id_kategori' => 'required|integer', // Sesuaikan jika nama kolom kategori Anda berbeda
            'isi' => 'required'
        ]);

        if ($this->request->getMethod() === 'post' && $validation->withRequest($this->request)->run()) {
            $data = [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'), // Sesuaikan jika nama kolom kategori Anda berbeda
                'slug' => url_title($this->request->getPost('judul'), '-', true), // Perbarui slug juga
            ];
            // Tambahkan logika untuk gambar jika ada perubahan
            // $file = $this->request->getFile('gambar');
            // if ($file && $file->isValid() && !$file->hasMoved()) { ... }

            $artikelModel->update($id, $data);
            return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil diupdate.');
        }

        $kategoriModel = new KategoriModel();
        return view('artikel/form_edit', [
            'title' => 'Edit Artikel',
            'artikel' => $artikelData,
            'kategori' => $kategoriModel->findAll(),
            'validation' => $validation
        ]);
    }

    // Method untuk menghapus artikel
    public function delete($id = null)
    {
        $artikel = new ArtikelModel();
        if ($artikel->delete($id)) {
            return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil dihapus.');
        } else {
            return redirect()->to('/admin/artikel')->with('error', 'Gagal menghapus artikel.');
        }
    }
}