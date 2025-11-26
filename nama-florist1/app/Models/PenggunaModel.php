<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table            = 'pengguna';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang diizinkan untuk diisi massal (mass assignment).
    // Ini sangat penting untuk keamanan!
    protected $allowedFields    = [
        'nama',
        'email',
        'kata_sandi',
        'telepon',
        'alamat',
        'peran'
    ];

    // Mengaktifkan fitur timestamp otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'dibuat_pada';
    protected $updatedField  = 'diupdate_pada';

    // (Opsional) Tambahkan callback untuk hashing password sebelum disimpan
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (! isset($data['data']['kata_sandi'])) {
            return $data;
        }

        $data['data']['kata_sandi'] = password_hash($data['data']['kata_sandi'], PASSWORD_DEFAULT);
        return $data;
    }
}