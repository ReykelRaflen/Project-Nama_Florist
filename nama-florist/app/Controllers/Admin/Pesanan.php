<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesananModel;
use App\Models\PenggunaModel;      // <-- Tambahkan
use App\Models\PapanBungaModel;   // <-- Tambahkan
use App\Models\DetailPesananModel; // <-- Tambahkan

class Pesanan extends BaseController
{
    protected $pesananModel;
    protected $penggunaModel;      // <-- Tambahkan
    protected $papanBungaModel;   // <-- Tambahkan
    protected $detailPesananModel; // <-- Tambahkan

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->penggunaModel = new PenggunaModel();      // <-- Tambahkan
        $this->papanBungaModel = new PapanBungaModel();   // <-- Tambahkan
        $this->detailPesananModel = new DetailPesananModel(); // <-- Tambahkan
        helper(['form', 'url', 'number']);
    }

    // [READ] Menampilkan semua pesanan
    public function index()
    {
        $query = $this->pesananModel
            ->select('pesanan.*, pengguna.nama as nama_pelanggan')
            ->join('pengguna', 'pengguna.id = pesanan.id_penyewa')
            ->orderBy('pesanan.dibuat_pada', 'DESC');

        // ... (logika filter tetap sama) ...
        $search = $this->request->getGet('search');
        if ($search) {
            $query->groupStart()
                ->where('pesanan.id', $search)
                ->orLike('pengguna.nama', $search)
                ->groupEnd();
        }
        $status = $this->request->getGet('status');
        if ($status) {
            $query->where('pesanan.status', $status);
        }

        $data = [
            'orders' => $query->paginate(10, 'orders'),
            'pager' => $this->pesananModel->pager,
            'search' => $search,
            'status' => $status,
        ];
        return view('admin/pesanan/index', $data);
    }

    // [CREATE] Menampilkan form tambah pesanan
    public function new()
    {
        $data = [
            'users' => $this->penggunaModel->where('peran', 'penyewa')->findAll(),
            'products' => $this->papanBungaModel->where('status', 'tersedia')->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        return view('admin/pesanan/new', $data);
    }

    // [CREATE] Memproses pembuatan pesanan baru
    public function create()
    {
        $rules = [
            'id_penyewa' => 'required|integer',
            'id_papan_bunga' => 'required|integer',
            'tanggal_sewa' => 'required|valid_date',
            'status' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $product = $this->papanBungaModel->find($this->request->getPost('id_papan_bunga'));
        if (!$product) {
            return redirect()->back()->withInput()->with('error', 'Produk tidak valid.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        
        $pesananData = [
            'id_penyewa' => $this->request->getPost('id_penyewa'),
            'tanggal_pesan' => date('Y-m-d'),
            'tanggal_sewa' => $this->request->getPost('tanggal_sewa'),
            'total_harga' => $product['harga'], // Harga diambil dari produk
            'teks_pesan' => $this->request->getPost('teks_pesan'),
            'status' => $this->request->getPost('status'),
        ];
        $this->pesananModel->insert($pesananData);
        $pesananId = $this->pesananModel->getInsertID();

        $detailPesananData = [
            'id_pesanan' => $pesananId,
            'id_papan_bunga' => $product['id'],
            'jumlah' => 1,
            'harga' => $product['harga'],
            'subtotal' => $product['harga'],
        ];
        $this->detailPesananModel->insert($detailPesananData);
        
        $db->transComplete();

        return redirect()->to('/admin/pesanan')->with('success', 'Pesanan manual berhasil ditambahkan.');
    }
    
    // [UPDATE] Menampilkan form edit pesanan
    public function edit($id = null)
    {
        $order = $this->pesananModel
            ->select('pesanan.*, detail_pesanan.id_papan_bunga')
            ->join('detail_pesanan', 'detail_pesanan.id_pesanan = pesanan.id')
            ->find($id);
            
        if (empty($order)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan');
        }

        $data = [
            'order' => $order,
            'users' => $this->penggunaModel->where('peran', 'penyewa')->findAll(),
            'products' => $this->papanBungaModel->findAll(), // Tampilkan semua produk untuk diedit
            'validation' => \Config\Services::validation(),
        ];
        return view('admin/pesanan/edit', $data);
    }

    // [UPDATE] Memproses pembaruan pesanan
    public function update($id = null)
    {
        $rules = [
            'id_penyewa' => 'required|integer',
            'id_papan_bunga' => 'required|integer',
            'tanggal_sewa' => 'required|valid_date',
            'status' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $product = $this->papanBungaModel->find($this->request->getPost('id_papan_bunga'));
        if (!$product) {
            return redirect()->back()->withInput()->with('error', 'Produk tidak valid.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $pesananData = [
            'id_penyewa' => $this->request->getPost('id_penyewa'),
            'tanggal_sewa' => $this->request->getPost('tanggal_sewa'),
            'total_harga' => $product['harga'],
            'teks_pesan' => $this->request->getPost('teks_pesan'),
            'status' => $this->request->getPost('status'),
        ];
        $this->pesananModel->update($id, $pesananData);

        // Update detail pesanan juga
        $this->detailPesananModel->where('id_pesanan', $id)->set([
            'id_papan_bunga' => $product['id'],
            'harga' => $product['harga'],
            'subtotal' => $product['harga'],
        ])->update();
        
        $db->transComplete();

        return redirect()->to('/admin/pesanan')->with('success', 'Pesanan berhasil diperbarui.');
    }

    // [DELETE] Menghapus pesanan
    public function delete($id = null)
    {
        // Transaksi untuk memastikan detail pesanan juga terhapus
        $db = \Config\Database::connect();
        $db->transStart();
        $this->detailPesananModel->where('id_pesanan', $id)->delete();
        $this->pesananModel->delete($id);
        $db->transComplete();

        return redirect()->to('/admin/pesanan')->with('success', 'Pesanan berhasil dihapus.');
    }
}