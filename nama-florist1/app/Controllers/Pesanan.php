<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PesananModel;

class Pesanan extends BaseController
{
    protected $pesananModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        helper(['number']);
    }   

    // Menampilkan halaman riwayat pesanan pengguna
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $data = [
            'orders' => $this->pesananModel
                ->where('id_penyewa', $userId)
                ->orderBy('dibuat_pada', 'DESC')
                ->findAll(),
        ];
        return view('pesanan_riwayat', $data);
    }

    // Menampilkan halaman detail satu pesanan
    public function show($id = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        
        // Query untuk mengambil detail pesanan lengkap
        $order = $this->pesananModel
            ->select('pesanan.*, pengguna.nama as nama_pelanggan, papan_bunga.nama as nama_produk, papan_bunga.gambar as gambar_produk')
            ->join('pengguna', 'pengguna.id = pesanan.id_penyewa')
            ->join('detail_pesanan', 'detail_pesanan.id_pesanan = pesanan.id')
            ->join('papan_bunga', 'papan_bunga.id = detail_pesanan.id_papan_bunga')
            ->where('pesanan.id', $id)
            ->where('pesanan.id_penyewa', $userId) // Keamanan: pastikan pesanan ini milik pengguna yg login
            ->first();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan atau bukan milik Anda.');
        }

        $data = [
            'order' => $order
        ];
        
        return view('pesanan_detail', $data);
    }
}