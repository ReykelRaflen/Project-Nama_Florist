<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_pesanan',
        'jumlah',
        'metode',
        'status',
        'tanggal_pembayaran',
        'id_transaksi'
    ];

    // Tabel ini hanya punya 'dibuat_pada', tidak ada 'diupdate_pada'.
    protected $useTimestamps = true;
    protected $createdField = 'dibuat_pada';
    protected $updatedField = null; // Di-set null karena tidak ada kolom updated
}