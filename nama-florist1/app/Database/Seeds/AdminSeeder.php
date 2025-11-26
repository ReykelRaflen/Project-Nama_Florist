<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\PenggunaModel; // <-- PENTING: Import PenggunaModel

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Inisialisasi model
        $model = new PenggunaModel();

        // Data untuk akun admin
        $adminData = [
            'nama'       => 'Administrator',
            'email'      => 'admin@namaflorist.id',
            'kata_sandi' => 'admin123', // Model akan meng-hash password ini secara otomatis
            'telepon'    => '081234567890', // Boleh diisi data dummy
            'alamat'     => 'Kantor Pusat Nama Florist', // Boleh diisi data dummy
            'peran'      => 'admin',
        ];

        // Cek apakah admin sudah ada berdasarkan email
        $existingAdmin = $model->where('email', $adminData['email'])->first();

        if (!$existingAdmin) {
            // Jika belum ada, masukkan data admin baru
            // Menggunakan metode insert dari model akan memicu callback beforeInsert (hashing)
            $model->insert($adminData);

            // Tampilkan pesan sukses di terminal
            echo "Akun admin default berhasil dibuat.\n";
            echo "Email: " . $adminData['email'] . "\n";
            echo "Password: " . 'admin123' . "\n";
        } else {
            // Jika sudah ada, tampilkan pesan bahwa akun sudah ada
            echo "Akun admin dengan email '" . $adminData['email'] . "' sudah ada.\n";
        }
    }
}