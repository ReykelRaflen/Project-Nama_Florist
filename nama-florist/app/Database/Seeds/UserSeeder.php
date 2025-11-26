<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\PenggunaModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Inisialisasi model
        $model = new PenggunaModel();

        // Data dummy untuk 3 pengguna biasa (penyewa)
        $usersData = [
            [
                'nama'       => 'Budi Santoso',
                'email'      => 'budi.s@example.com',
                'kata_sandi' => 'user123', // Akan di-hash oleh model
                'telepon'    => '081211112222',
                'alamat'     => 'Jl. Merdeka No. 10, Jakarta',
                'peran'      => 'penyewa',
            ],
            [
                'nama'       => 'Citra Lestari',
                'email'      => 'citra.l@example.com',
                'kata_sandi' => 'user123', // Password bisa sama untuk data dummy
                'telepon'    => '081333334444',
                'alamat'     => 'Jl. Pahlawan No. 25, Surabaya',
                'peran'      => 'penyewa',
            ],
            [
                'nama'       => 'Dewi Anggraini',
                'email'      => 'dewi.a@example.com',
                'kata_sandi' => 'user123',
                'telepon'    => '081555556666',
                'alamat'     => 'Jl. Gajah Mada No. 15, Bandung',
                'peran'      => 'penyewa',
            ],
        ];

        // Looping untuk memasukkan setiap pengguna
        foreach ($usersData as $userData) {
            // Cek apakah pengguna sudah ada berdasarkan email
            $existingUser = $model->where('email', $userData['email'])->first();

            if (!$existingUser) {
                // Jika belum ada, masukkan data pengguna baru
                // Metode insert akan memicu hashing password secara otomatis
                $model->insert($userData);
                echo "Akun pengguna untuk " . $userData['email'] . " berhasil dibuat.\n";
            } else {
                echo "Akun pengguna dengan email '" . $userData['email'] . "' sudah ada.\n";
            }
        }
    }
}