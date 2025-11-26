<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPesananModel extends Model
{
    protected $table            = 'detail_pesanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'id_pesanan',
        'id_papan_bunga',
        'jumlah',
        'harga',
        'subtotal'
    ];

    // Tabel ini tidak memiliki kolom timestamp, jadi kita nonaktifkan.
    protected $useTimestamps = false;
}