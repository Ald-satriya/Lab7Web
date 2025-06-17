<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ArtikelModel;

class PostApi extends ResourceController
{
    // CORS helper
    private function setCors() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
    }

    public function index()
    {
        $this->setCors();

        $model = new ArtikelModel();
        return $this->respond($model->findAll(), 200);
    }

    public function create()
    {
        $this->setCors();

        $model = new ArtikelModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi' => $this->request->getVar('isi'),
        ];

        if (!$data['judul'] || !$data['isi']) {
            return $this->failValidationErrors('Judul dan isi harus diisi');
        }

        $model->insert($data);
        return $this->respondCreated([
            'status' => 201,
            'message' => 'Data berhasil disimpan',
            'data' => $data
        ]);
    }

    public function update($id = null)
    {
        $this->setCors();

        $model = new ArtikelModel();

        if (!$model->find($id)) {
            return $this->failNotFound("Data dengan ID $id tidak ditemukan");
        }

        parse_str(file_get_contents("php://input"), $data);

        if (empty($data['judul']) || empty($data['isi'])) {
            return $this->failValidationErrors('Judul dan isi harus diisi');
        }

        $model->update($id, $data);
        return $this->respond([
            'status' => 200,
            'message' => 'Data berhasil diperbarui',
            'data' => $data
        ]);
    }

    public function delete($id = null)
    {
        $this->setCors();

        $model = new ArtikelModel();

        if (!$model->find($id)) {
            return $this->failNotFound("Data dengan ID $id tidak ditemukan");
        }

        $model->delete($id);
        return $this->respondDeleted([
            'status' => 200,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    // WAJIB UNTUK CORS (preflight OPTIONS)
    public function options()
    {
        $this->setCors();
        return $this->respond(null, 200);
    }
}