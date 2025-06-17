<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    public function admin_index()
    {
        $q = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
        $page = (int) ($this->request->getVar('page') ?? 1);

        $model = new ArtikelModel();

        $builder = $model->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

        if (!empty($q)) {
            $builder->like('artikel.judul', $q);
        }

        if (!empty($kategori_id)) {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        $artikel = $builder->paginate(10, 'default', $page);
        $pager = $model->pager;

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'artikel' => $artikel,
                'pager' => [
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

    public function add()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'id_kategori' => 'required|integer'
        ]);

        if ($validation->withRequest($this->request)->run()) {
            $file = $this->request->getFile('gambar');
            $namaGambar = null;

            if ($file && $file->isValid()) {
                $file->move(ROOTPATH . 'public/gambar');
                $namaGambar = $file->getName();
            }

            $artikel = new ArtikelModel();
            $artikel->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul')),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'gambar' => $namaGambar,
                'status' => 1
            ]);

            return redirect()->to('/admin/artikel');
        }

        $kategoriModel = new KategoriModel();
        return view('artikel/form_add', [
            'title' => 'Tambah Artikel',
            'kategori' => $kategoriModel->findAll()
        ]);
    }

    public function edit($id)
    {
        $artikel = new ArtikelModel();
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'id_kategori' => 'required|integer'
        ]);

        if ($validation->withRequest($this->request)->run()) {
            $artikel->update($id, [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
            ]);

            return redirect()->to('/admin/artikel');
        }

        $data['artikel'] = $artikel->find($id);
        $kategoriModel = new KategoriModel();

        $data['kategori'] = $kategoriModel->findAll();
        $data['title'] = "Edit Artikel";

        return view('artikel/form_edit', $data);
    }

    public function delete($id)
    {
        $artikel = new ArtikelModel();
        $artikel->delete($id);
        return redirect()->to('/admin/artikel');
    }
}
