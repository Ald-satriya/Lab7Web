<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table          = 'artikel';
    protected $primaryKey     = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields    = ['judul', 'isi', 'status', 'slug', 'gambar', 'id_kategori'];
    protected $returnType     = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    // protected $deletedField  = 'deleted_at'; // Hanya jika useSoftDeletes diaktifkan

    /**
     * Mengambil semua artikel beserta nama kategori terkait (tanpa pagination).
     */
    public function getArtikelDenganKategori()
    {
        // Pastikan 'kategori.id_kategori' sesuai dengan nama primary key di tabel kategori Anda.
        // Jika primary key tabel kategori adalah 'id', ubah menjadi 'kategori.id'.
        return $this->select('artikel.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                    ->orderBy('artikel.id', 'DESC')
                    ->findAll();
    }

    /**
     * Mengambil data artikel beserta nama kategori, dengan dukungan pagination dan filter.
     * Method ini digunakan oleh Artikel::admin_index() dan AjaxController::get().
     *
     * @param int         $perPage    Jumlah item yang akan ditampilkan per halaman.
     * @param string      $group      Nama grup pager yang digunakan oleh CodeIgniter (misal: 'artikel').
     * @param string|null $keyword    Kata kunci untuk pencarian berdasarkan judul artikel (opsional).
     * @param int|null    $kategoriId ID kategori untuk memfilter artikel (opsional).
     */
    public function getArtikelDenganKategoriPaginated($perPage = 10, $group = 'default', $keyword = null, $kategoriId = null)
    {
        $builder = $this->select('artikel.*, kategori.nama_kategori')
                        // PERHATIKAN: Pastikan 'kategori.id_kategori' sesuai dengan primary key tabel kategori Anda.
                        // Jika primary key tabel kategori adalah 'id', ubah menjadi 'kategori.id'.
                        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

        if (!empty($keyword)) {
            $builder->like('artikel.judul', $keyword);
        }

        if (!empty($kategoriId)) {
            $builder->where('artikel.id_kategori', $kategoriId);
        }

        // PENTING: Tentukan urutan hasil untuk pagination yang konsisten
        $builder->orderBy('artikel.id', 'DESC');

        // Lakukan pagination
        return $builder->paginate($perPage, $group);
    }
}