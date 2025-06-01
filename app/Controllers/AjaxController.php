<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Controller;

class AjaxController extends Controller
{
    protected $helpers = ['form', 'url'];

    public function index()
    {
        $data = ['title' => 'Data Artikel'];
        return view('ajax/index', $data);
    }

    public function getPaginatedData()
    {
        $model = new ArtikelModel();
        $perPage = 5;

        $data = [
            'artikel' => $model->getArtikelDenganKategoriPaginated($perPage, 'artikel'),
            'pager'   => $model->pager
        ];

        return view('ajax/data', $data);
    }

    public function save()
    {
        $judul = $this->request->getPost('judul');
        $isi   = $this->request->getPost('isi');

        if (!$judul || !$isi) {
            return $this->response->setJSON([
                'status' => 'ERROR',
                'message' => 'Judul dan isi tidak boleh kosong.'
            ]);
        }

        $model = new ArtikelModel();
        $data = [
            'judul'  => $judul,
            'isi'    => $isi,
            'slug'   => url_title($judul, '-', true),
            'status' => 1
        ];

        if ($model->insert($data)) {
            return $this->response->setJSON([
                'status' => 'OK',
                'message' => 'Data berhasil ditambahkan.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'ERROR',
            'message' => 'Gagal menambahkan data.'
        ]);
    }

    public function edit($id)
    {
        $model = new ArtikelModel();
        $data = $model->find($id);

        if ($data) {
            return $this->response->setJSON($data);
        }

        return $this->response->setJSON([
            'status' => 'ERROR',
            'message' => 'Data tidak ditemukan.'
        ]);
    }

    public function update($id)
    {
        $judul = $this->request->getPost('judul');
        $isi   = $this->request->getPost('isi');

        if (!$judul || !$isi) {
            return $this->response->setJSON([
                'status' => 'ERROR',
                'message' => 'Judul dan isi tidak boleh kosong.'
            ]);
        }

        $model = new ArtikelModel();
        $data = [
            'judul' => $judul,
            'isi'   => $isi,
            'slug'  => url_title($judul, '-', true)
        ];

        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'ERROR',
            'message' => 'Gagal mengupdate data.'
        ]);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();

        if ($model->delete($id)) {
            return $this->response->setJSON([
                'status' => 'OK',
                'message' => 'Data berhasil dihapus.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'ERROR',
            'message' => 'Gagal menghapus data.'
        ]);
    }
}
