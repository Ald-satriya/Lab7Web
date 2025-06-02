<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PostModel;

class Post extends ResourceController
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new PostModel(); // Model sudah benar
    }

    // GET /post
    public function index()
    {
        $data = $this->model->orderBy('id', 'DESC')->findAll();
        return $this->respond(['status' => 200, 'data' => $data]);
    }

    // POST /post
    public function create()
    {
        $data = $this->request->getPost() ?: $this->request->getJSON(true);

        if (!$data || !isset($data['judul']) || !isset($data['isi'])) {
            return $this->failValidationErrors('Judul dan isi wajib diisi.');
        }

        if (!isset($data['slug'])) {
            $data['slug'] = url_title($data['judul'], '-', true);
        }

        $this->model->insert($data);

        return $this->respondCreated([
            'status' => 201,
            'messages' => ['success' => 'Data artikel berhasil ditambahkan.']
        ]);
    }

    // GET /post/{id}
    public function show($id = null)
    {
        $data = $this->model->find($id);
        return $data ? $this->respond($data) : $this->failNotFound('Data tidak ditemukan.');
    }

    // PUT /post/{id}
    public function update($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound('Data tidak ditemukan.');
        }

        $data = $this->request->getRawInput();

        if (!isset($data['judul']) || !isset($data['isi'])) {
            return $this->failValidationErrors('Judul dan isi wajib diisi.');
        }

        if (!isset($data['slug']) && isset($data['judul'])) {
            $data['slug'] = url_title($data['judul'], '-', true);
        }

        $this->model->update($id, $data);

        return $this->respond([
            'status' => 200,
            'messages' => ['success' => 'Data artikel berhasil diubah.']
        ]);
    }

    // DELETE /post/{id}
    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound('Data tidak ditemukan.');
        }

        $this->model->delete($id);
        return $this->respondDeleted([
            'status' => 200,
            'messages' => ['success' => 'Data artikel berhasil dihapus.']
        ]);
    }
}
