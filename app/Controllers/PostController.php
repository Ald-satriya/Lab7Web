<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class PostController extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\PostModel';
    protected $format    = 'json';

    public function index()
    {
        // Ambil semua data artikel, urutkan berdasarkan ID terbaru
        $data = $this->model->orderBy('id', 'DESC')->findAll();
        // Beri respons dengan format JSON yang rapi
        return $this->respond([
            'status'  => 200,
            'message' => 'Data berhasil diambil.',
            'data'    => [
                'artikel' => $data // Bungkus data artikel dalam array 'artikel'
            ]
        ]);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound('Data dengan ID ' . $id . ' tidak ditemukan.');
        }
        return $this->respond([
            'status'  => 200,
            'message' => 'Data ditemukan.',
            'data'    => $data
        ]);
    }

    public function create()
    {
        // Ambil data JSON dari body request dan ubah ke array asosiatif
        $data = $this->request->getJSON(true);

        // Lakukan validasi data menggunakan aturan validasi dari model
        if (!$this->validate($this->model->getValidationRules(), $this->model->getValidationMessages())) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Generate slug dari judul (jika judul ada)
        if (isset($data['judul'])) {
             $data['slug'] = url_title($data['judul'], '-', true);
        } else {
             $data['slug'] = ''; // Atau atur default lain jika judul tidak wajib
        }

        // Set status default jika tidak disediakan (misal: 0 untuk draft)
        $data['status'] = $data['status'] ?? 0;

        // Coba simpan data ke database
        if ($this->model->insert($data)) {
            // Jika berhasil, ambil data yang baru saja disimpan untuk respons
            $insertedData = $this->model->find($this->model->getInsertID());
            return $this->respondCreated([ // Respond dengan status 201 Created
                'status'  => 201,
                'message' => 'Data artikel berhasil ditambahkan.',
                'data'    => $insertedData
            ]);
        }
        // Jika gagal menyimpan
        return $this->failServerError('Gagal menyimpan data.');
    }

    public function update($id = null)
    {
        // Cek apakah data dengan ID tersebut ada
        if (!$this->model->find($id)) {
            return $this->failNotFound('Data dengan ID ' . $id . ' tidak ditemukan.');
        }

        // Ambil data JSON dari body request dan ubah ke array asosiatif
        $data = $this->request->getJSON(true);

        // Lakukan validasi data menggunakan aturan validasi dari model
        // Pastikan validasi is_unique pada slug tidak mengganggu jika slug tidak berubah
        if (!$this->validate($this->model->getValidationRules(), $this->model->getValidationMessages())) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Generate atau update slug jika judul diubah
        if (isset($data['judul'])) {
             $data['slug'] = url_title($data['judul'], '-', true);
        }
        // Set status default jika tidak disediakan
        $data['status'] = $data['status'] ?? 0;


        // Coba update data ke database
        if ($this->model->update($id, $data)) {
            // Jika berhasil, ambil data yang baru saja diupdate untuk respons
            $updatedData = $this->model->find($id);
            return $this->respond([ // Respond dengan status 200 OK
                'status'  => 200,
                'message' => 'Data artikel berhasil diupdate.',
                'data'    => $updatedData
            ]);
        }
        // Jika gagal mengupdate
        return $this->failServerError('Gagal mengupdate data.');
    }

    public function delete($id = null)
    {
        // Cek apakah data dengan ID tersebut ada
        if (!$this->model->find($id)) {
            return $this->failNotFound('Data dengan ID ' . $id . ' tidak ditemukan.');
        }

        // Coba hapus data dari database
        if ($this->model->delete($id)) {
            return $this->respondDeleted([ // Respond dengan status 200 OK (untuk delete)
                'status'  => 200,
                'message' => 'Data artikel berhasil dihapus.'
            ]);
        }
        // Jika gagal menghapus
        return $this->failServerError('Gagal menghapus data.');
    }
}