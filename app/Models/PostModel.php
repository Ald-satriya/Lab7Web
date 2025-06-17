<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table            = 'artikel'; // Ganti dari 'post' ke 'artikel'
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = ['judul', 'isi', 'slug', 'status', 'id_kategori', 'gambar'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'judul' => 'required|min_length[3]',
        'isi'   => 'required|min_length[5]',
    ];

    protected $validationMessages = [
        'judul' => [
            'required' => 'Judul wajib diisi.',
            'min_length' => 'Judul minimal 3 karakter.'
        ],
        'isi' => [
            'required' => 'Isi artikel wajib diisi.',
            'min_length' => 'Isi minimal 5 karakter.'
        ],
    ];

    protected $skipValidation = false;
}
