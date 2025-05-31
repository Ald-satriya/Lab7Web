<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Controller;

class AjaxController extends Controller
{
    protected $helpers = ['form', 'url'];

    // Halaman utama AJAX
    public function index()
    {
        $data = ['title' => 'Data Artikel'];
        return view('ajax/index', $data);
    }

    // Ambil semua data artikel (JSON)
    public function getData()
    {
        $model = new ArtikelModel();
        $data = $model->findAll();

        return $this->response->setJSON($data);
    }

    // Tambah artikel baru (POST)
    public function save()
    {
        $judul = $this->request->getPost('judul');
        $isi   = $this->request->getPost('isi');

        if (empty($judul) || empty($isi)) {
            return $this->response->setJSON([
                'status' => 'ERROR',
                'message' => 'Judul dan isi tidak boleh kosong.'
            ]);
        }

        $model = new ArtikelModel();
        $data = [
            'judul'  => $judul,
            'isi'    => $isi,
            'slug'   => url_title($judul, '-', true), // Buat slug dari judul
            'status' => 1 // Default: Published
        ];

        if ($model->insert($data)) {
            return $this->response->setJSON([
                'status' => 'OK',
                'message' => 'Data berhasil ditambahkan'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'ERROR',
            'message' => 'Gagal menambahkan data'
        ]);
    }

    // Ambil satu data artikel berdasarkan ID (GET)
    public function edit($id)
    {
        $model = new ArtikelModel();
        $data = $model->find($id);

        if ($data) {
            return $this->response->setJSON($data);
        }

        return $this->response->setJSON([
            'status' => 'ERROR',
            'message' => 'Data tidak ditemukan'
        ]);
    }

    // Update artikel berdasarkan ID (POST)
    public function update($id)
    {
        $judul = $this->request->getPost('judul');
        $isi   = $this->request->getPost('isi');

        if (empty($judul) || empty($isi)) {
            return $this->response->setJSON([
                'status' => 'ERROR',
                'message' => 'Judul dan isi tidak boleh kosong.'
            ]);
        }

        $model = new ArtikelModel();
        $data = [
            'judul' => $judul,
            'isi'   => $isi,
            'slug'  => url_title($judul, '-', true) // Update slug saat judul diubah
        ];

        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'ERROR',
            'message' => 'Gagal mengupdate data'
        ]);
    }

    // Hapus artikel berdasarkan ID (DELETE)
    public function delete($id)
    {
        $model = new ArtikelModel();

        if ($model->delete($id)) {
            return $this->response->setJSON([
                'status' => 'OK',
                'message' => 'Data berhasil dihapus'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'ERROR',
            'message' => 'Gagal menghapus data'
        ]);
    }
}
