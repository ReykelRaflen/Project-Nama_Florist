<?php

namespace App\Models;

use CodeIgniter\Model;

class PapanBungaModel extends Model
{
    protected $table            = 'papan_bunga';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'nama',
        'ukuran',
        'bahan',
        'harga',
        'stok',
        'gambar',
        'status'
    ];

    // Mengaktifkan fitur timestamp otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'dibuat_pada';
    protected $updatedField  = 'diupdate_pada';
}