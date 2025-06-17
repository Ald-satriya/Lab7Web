<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
<<<<<<< HEAD
    // Pastikan helpers 'form', 'url', dan 'text' dimuat
    // 'text' diperlukan untuk url_title()
    protected $helpers = ['form', 'url', 'text'];

    // Method default untuk halaman artikel frontend (jika ada)
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        // Method ini tidak menggunakan pagination, hanya ambil semua data
        $artikel = $model->getArtikelDenganKategori();

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
     * Method ini menangani halaman admin artikel, termasuk pagination dan filter.
     * Dipanggil oleh rute 'admin/artikel' di grup 'admin'.
     */
=======
>>>>>>> 0e864c0 (Praktikum 10 : Update API with Improvisasi)
    public function admin_index()
    {
        // Ambil parameter pencarian ('q') dan filter kategori ('kategori_id') dari URL
        $q = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
<<<<<<< HEAD

        // Model untuk artikel dan kategori
        $artikelModel = new ArtikelModel();
        $kategoriModel = new KategoriModel();
=======
        $page = (int) ($this->request->getVar('page') ?? 1);

        $model = new ArtikelModel();

        $builder = $model->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');
>>>>>>> 0e864c0 (Praktikum 10 : Update API with Improvisasi)

        // Inisialisasi query builder untuk artikel dengan join ke kategori
        $builder = $artikelModel->select('artikel.*, kategori.nama_kategori')
                                ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

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
        $builder->orderBy('artikel.id', 'ASC'); // Mengurutkan dari artikel terbaru

<<<<<<< HEAD
        // Atur jumlah item per halaman menjadi 5
        $perPage = 5;

        // Dapatkan data artikel yang sudah dipaginasi
        // Parameter 'default' adalah nama grup pagination (sesuaikan jika perlu)
        $artikel = $builder->paginate($perPage, 'default');
        $pager = $artikelModel->pager; // Dapatkan objek pager dari model

        // Jika ini adalah permintaan AJAX, kembalikan JSON (seperti di AjaxController::get())
        // Meskipun untuk /admin/artikel kita tidak menggunakan AJAX untuk pagination
        // blok ini bisa berguna jika Anda ingin menambahkan fitur AJAX di masa depan
=======
>>>>>>> 0e864c0 (Praktikum 10 : Update API with Improvisasi)
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'artikel' => $artikel,
                'pager' => [
<<<<<<< HEAD
                    'links' => $pager->links('default')
                ]
            ]);
        }

        // Jika bukan permintaan AJAX, tampilkan view HTML penuh
        return view('artikel/admin_index', [
            'artikel' => $artikel,
            'pager' => $pager,
            'q' => $q, // Untuk mengisi kembali nilai pencarian di form
            'kategori_id' => $kategori_id, // Untuk membuat opsi kategori terpilih di dropdown
            'kategori' => $kategoriModel->findAll(), // Daftar semua kategori untuk dropdown
            'title' => 'Manajemen Artikel'
        ]);
    }

    // Method untuk menambahkan artikel baru
=======
                    'links' => $pager->links('default'),
                ],
            ]);
        }

        $kategoriModel = new KategoriModel();
        return view('artikel/admin_index', [
            'kategori' => $kategoriModel->findAll(),
        ]);
    }

    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->getArtikelDenganKategori();

        return view('artikel/index', compact('artikel', 'title'));
    }

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

>>>>>>> 0e864c0 (Praktikum 10 : Update API with Improvisasi)
    public function add()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required|min_length[3]',
            'id_kategori' => 'required|integer'
        ]);

        if ($this->request->getMethod() === 'post' && $validation->withRequest($this->request)->run()) {
            $file = $this->request->getFile('gambar');
            $namaGambar = null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $file->move(ROOTPATH . 'public/gambar');
                $namaGambar = $file->getName();
            }

            $artikel = new ArtikelModel();
            $artikel->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul'), '-', true),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'gambar' => $namaGambar,
                'status' => 1 // Misal: 1 untuk published
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
            'id_kategori' => 'required|integer'
        ]);

        if ($this->request->getMethod() === 'post' && $validation->withRequest($this->request)->run()) {
            $data = [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
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