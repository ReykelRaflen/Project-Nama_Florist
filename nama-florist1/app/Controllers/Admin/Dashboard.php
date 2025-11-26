<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesananModel;
use App\Models\PenggunaModel;
use App\Models\PapanBungaModel;


class Dashboard extends BaseController
{
    protected $pesananModel;
    protected $penggunaModel;
    protected $papanBungaModel; // <-- Tambahkan properti

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->penggunaModel = new PenggunaModel();
        $this->papanBungaModel = new PapanBungaModel(); // <-- Inisialisasi model
    }

    public function index()
    {
        $data = [
            'pesananHariIni' => $this->pesananModel->where('DATE(dibuat_pada)', date('Y-m-d'))->countAllResults(),
            // Logika pendapatan perlu dibuat lebih kompleks (misal, menjumlahkan total_harga dari pesanan yang 'selesai')
            'totalPendapatan' => $this->pesananModel->where('status', 'selesai')->selectSum('total_harga')->get()->getRow()->total_harga ?? 0,
            'pembayaranTertunda' => $this->pesananModel->where('status', 'menunggu')->countAllResults(),
            'penggunaBaru' => $this->penggunaModel->where('dibuat_pada >=', date('Y-m-d H:i:s', strtotime('-24 hours')))->countAllResults(),
            'pesananTerbaru' => $this->pesananModel
                                ->select('pesanan.*, pengguna.nama as nama_pelanggan')
                                ->join('pengguna', 'pengguna.id = pesanan.id_penyewa')
                                ->orderBy('pesanan.dibuat_pada', 'DESC')
                                ->limit(3) // Batasi 3 saja sesuai desain
                                ->findAll(),
            'produkTeratas' => $this->papanBungaModel // <-- Tambahkan data produk
                               ->orderBy('dibuat_pada', 'DESC')
                               ->limit(3) // Ambil 3 produk terbaru sebagai contoh
                               ->findAll(),
        ];

        return view('admin/dashboard', $data);
    }
}