<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;

class Auth extends BaseController
{
    protected $penggunaModel;

    public function __construct()
    {
        // Inisialisasi model di constructor
        $this->penggunaModel = new PenggunaModel();
        // Load helper yang dibutuhkan
        helper(['form']);
    }

    public function register()
    {
        // Hanya menampilkan halaman view untuk form registrasi
        return view('register');
    }

    // app/Controllers/Auth.php

    public function processRegister()
    {
        // 1. Aturan Validasi (dengan tambahan untuk telepon)
        $rules = [
            'nama' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[pengguna.email]',
            'telepon' => 'required|numeric|min_length[9]|max_length[13]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'terms' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Anda harus menyetujui Syarat & Ketentuan untuk melanjutkan pendaftaran.'
                ]
            ]
        ];

        // 2. Jalankan Validasi
        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke form dengan errornya
            return redirect()->to('/register')->withInput()->with('validation', $this->validator);
        }

        // 3. Jika Validasi Berhasil, Siapkan Data dan Simpan
        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'telepon' => $this->request->getPost('telepon'), // Menambahkan telepon
            'kata_sandi' => $this->request->getPost('password'), // Password akan di-hash oleh model
            'peran' => 'penyewa' // Default peran saat registrasi
        ];

        $this->penggunaModel->save($data);

        // 4. Redirect ke halaman login dengan pesan sukses
        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
    public function login()
    {
        // Hanya menampilkan halaman view untuk form login
        return view('login');
    }

    public function processLogin()
    {
        // 1. Ambil data dari form
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // 2. Cari pengguna berdasarkan email
        $user = $this->penggunaModel->where('email', $email)->first();

        // 3. Cek Pengguna dan Password
        if ($user && password_verify($password, $user['kata_sandi'])) {
            // Jika pengguna ditemukan dan password cocok
            $session_data = [
                'user_id' => $user['id'],
                'nama' => $user['nama'],
                'email' => $user['email'],
                'peran' => $user['peran'],
                'isLoggedIn' => TRUE
            ];

            session()->set($session_data);

            // Redirect berdasarkan peran
            if ($user['peran'] == 'admin') {
                return redirect()->to('/admin/dashboard'); // Arahkan ke dashboard admin
            } else {
                return redirect()->to('/'); // Arahkan ke halaman utama untuk penyewa
            }
        } else {
            // Jika pengguna tidak ditemukan atau password salah
            return redirect()->to('/login')->withInput()->with('error', 'Email atau password salah.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda berhasil logout.');
    }
}