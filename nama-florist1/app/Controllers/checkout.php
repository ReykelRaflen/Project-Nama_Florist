<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PapanBungaModel;
use App\Models\PesananModel;
use App\Models\DetailPesananModel;
use App\Models\PembayaranModel;
use App\Models\PenggunaModel;

class Checkout extends BaseController
{
    protected $papanBungaModel;
    protected $pesananModel;
    protected $detailPesananModel;
    protected $pembayaranModel;
    protected $penggunaModel;
     public function __construct()
    {
        // Inisialisasi semua model yang dibutuhkan
        $this->papanBungaModel = new PapanBungaModel();
        $this->pesananModel = new PesananModel();
        $this->detailPesananModel = new DetailPesananModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->penggunaModel = new PenggunaModel();
        helper(['form', 'number']);
    }

    /**
     * Fungsi index() TIDAK KITA GUNAKAN DALAM TES INI, jadi biarkan saja.
     * Cukup pastikan view checkout.php bisa diakses.
     */
    public function index($productId)
    {
        // Logika minimal untuk menampilkan view
        // Kita butuh variabel $validation, $product, dan $user agar view tidak error
        $papanBungaModel = new \App\Models\PapanBungaModel();
        $penggunaModel = new \App\Models\PenggunaModel();
        
        $data = [
            'product' => $papanBungaModel->find($productId),
            'user' => $penggunaModel->find(session()->get('user_id')),
            'validation' => \Config\Services::validation()
        ];
        return view('checkout', $data);
    }

    /**
     * Fungsi process() yang disederhanakan untuk debugging.
     */
   public function process()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/login');
    }

    $rules = [
        'product_id'        => 'required|integer',
        'nama_pemesan'      => 'required|min_length[3]',
        'telepon_pemesan'   => 'required|numeric|min_length[10]',
        'nama_penerima'     => 'required|min_length[3]',
        'telepon_penerima'  => 'required|numeric|min_length[10]',
        'alamat_penerima'   => 'required|min_length[10]',
        'tanggal_sewa'      => 'required|valid_date',
        'teks_pesan'        => 'required|min_length[5]',
        'metode_pembayaran' => 'required|in_list[transfer_bank,tunai]'
    ];

    if (!$this->validate($rules)) {
        $productId = $this->request->getPost('product_id');
        if (empty($productId)) {
            return redirect()->to('/katalog')->with('error', 'Terjadi kesalahan, produk tidak ditemukan.');
        }
        return redirect()->to('/checkout/' . $productId)->withInput()->with('validation', $this->validator);
    }
    
    $productId = (int) $this->request->getPost('product_id');
    $product = $this->papanBungaModel->find($productId);

    if (!$product || $product['stok'] < 1) {
        return redirect()->to('/katalog')->with('error', 'Maaf, stok produk sudah habis.');
    }

    $db = \Config\Database::connect();
    $db->transBegin();

    try {
        $detailPengiriman = "Penerima: " . $this->request->getPost('nama_penerima') . "\nTelepon Penerima: " . $this->request->getPost('telepon_penerima') . "\nAlamat: " . $this->request->getPost('alamat_penerima');
        $ucapan = "\n\nUcapan: " . $this->request->getPost('teks_pesan');

        // [INI PERUBAHAN UTAMA] Hapus 'tanggal_pesan' dari sini
        $pesananData = [
            'id_penyewa'    => session()->get('user_id'),
            'tanggal_sewa'  => $this->request->getPost('tanggal_sewa'),
            'total_harga'   => $product['harga'],
            'teks_pesan'    => $detailPengiriman . $ucapan,
            'status'        => 'menunggu',
        ];
        // Biarkan Model yang mengisi 'dibuat_pada' dan 'diupdate_pada' secara otomatis
        $this->pesananModel->insert($pesananData);
        $pesananId = $this->pesananModel->getInsertID();
        
        if (!$pesananId) { throw new \Exception('Gagal insert pesanan.'); }

        // ... sisa kode insert ke detail_pesanan dan pembayaran ...
        $detailPesananData = [ 'id_pesanan' => $pesananId, 'id_papan_bunga' => $productId, 'jumlah' => 1, 'harga' => $product['harga'], 'subtotal' => $product['harga'] ];
        $this->detailPesananModel->insert($detailPesananData);
        
        $pembayaranData = [ 'id_pesanan' => $pesananId, 'jumlah' => $product['harga'], 'metode' => $this->request->getPost('metode_pembayaran'), 'status' => 'menunggu' ];
        $this->pembayaranModel->insert($pembayaranData);

        $this->papanBungaModel->where('id', $productId)->decrement('stok', 1);

    } catch (\Exception $e) {
        $db->transRollback(); // Batalkan transaksi jika ada error
        log_message('error', '[CheckoutProcess] ' . $e->getMessage());
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan data.');
    }

    if ($db->transStatus() === false) {
        $db->transRollback();
        log_message('error', 'Checkout Transaction Failed.');
        return redirect()->back()->withInput()->with('error', 'Gagal memproses pesanan, silakan coba lagi.');
    } else {
        $db->transCommit();
        return redirect()->to('/my-orders/' . $pesananId)->with('success', 'Pesanan Anda berhasil dibuat!');
    }
}
}