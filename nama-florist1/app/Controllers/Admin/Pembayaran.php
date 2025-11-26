<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\PesananModel; // Diperlukan untuk mengambil daftar pesanan

class Pembayaran extends BaseController
{
    protected $pembayaranModel;
    protected $pesananModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->pesananModel = new PesananModel();
        helper(['form', 'url', 'number', 'date']);
    }

    // [READ] Menampilkan semua pembayaran
    public function index()
    {
        $query = $this->pembayaranModel
            ->select('pembayaran.*, pesanan.id as invoice_id, pengguna.nama as nama_pelanggan')
            ->join('pesanan', 'pesanan.id = pembayaran.id_pesanan')
            ->join('pengguna', 'pengguna.id = pesanan.id_penyewa')
            ->orderBy('pembayaran.dibuat_pada', 'DESC');

        // Filter: Pencarian
        $search = $this->request->getGet('search');
        if ($search) {
            $query->groupStart()
                ->where('pesanan.id', $search)
                ->orLike('pengguna.nama', $search)
                ->groupEnd();
        }
        
        // Filter: Status
        $status = $this->request->getGet('status');
        if ($status) {
            $query->where('pembayaran.status', $status);
        }
        
        // Filter: Metode
        $method = $this->request->getGet('method');
        if ($method) {
            $query->where('pembayaran.metode', $method);
        }

        // Hitung KPI berdasarkan query yang belum dipaginasi
        $kpiQuery = clone $query;
        $kpi = [
            'revenue' => $kpiQuery->where('pembayaran.status', 'lunas')->where('MONTH(pembayaran.dibuat_pada)', date('m'))->where('YEAR(pembayaran.dibuat_pada)', date('Y'))->selectSum('jumlah')->get()->getRow()->jumlah ?? 0,
            'pending' => (clone $kpiQuery)->where('pembayaran.status', 'menunggu')->countAllResults(),
            'paid' => (clone $kpiQuery)->where('pembayaran.status', 'lunas')->countAllResults(),
            'failed' => (clone $kpiQuery)->whereIn('pembayaran.status', ['gagal', 'dikembalikan'])->countAllResults(),
        ];
        
        $data = [
            'payments' => $query->paginate(10, 'payments'),
            'pager' => $this->pembayaranModel->pager,
            'search' => $search,
            'status' => $status,
            'method' => $method,
            'kpi' => $kpi,
        ];

        return view('admin/pembayaran/index', $data);
    }

    // [CREATE] Menampilkan form tambah pembayaran
    public function new()
    {
        $data = [
            'orders' => $this->pesananModel
                ->select('pesanan.id, pengguna.nama')
                ->join('pengguna', 'pengguna.id = pesanan.id_penyewa')
                ->where('NOT EXISTS (SELECT 1 FROM pembayaran WHERE pembayaran.id_pesanan = pesanan.id)', null, false)
                ->orderBy('pesanan.id', 'DESC')
                ->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        return view('admin/pembayaran/new', $data);
    }

    // [CREATE] Memproses pembuatan pembayaran baru
    public function create()
    {
        $rules = [
            'id_pesanan' => 'required|integer|is_unique[pembayaran.id_pesanan]',
            'jumlah' => 'required|numeric',
            'metode' => 'required|in_list[transfer_bank,tunai]',
            'status' => 'required|in_list[menunggu,lunas,gagal,dikembalikan]',
            'id_transaksi' => 'permit_empty',
            'tanggal_pembayaran' => 'permit_empty|valid_date'
        ];
        $messages = ['id_pesanan' => ['is_unique' => 'Pesanan ini sudah memiliki data pembayaran.']];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $this->pembayaranModel->save($this->request->getPost());
        
        if ($this->request->getPost('status') === 'lunas') {
            $this->pesananModel->update($this->request->getPost('id_pesanan'), ['status' => 'dikonfirmasi']);
        }

        return redirect()->to('/admin/pembayaran')->with('success', 'Pembayaran manual berhasil ditambahkan.');
    }

    // [UPDATE] Menampilkan form edit pembayaran
    public function edit($id = null)
    {
        $payment = $this->pembayaranModel->find($id);
        if (empty($payment)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pembayaran tidak ditemukan');
        }

        $data = [
            'payment' => $payment,
            'order' => $this->pesananModel
                ->select('pesanan.id, pengguna.nama')
                ->join('pengguna', 'pengguna.id = pesanan.id_penyewa')
                ->find($payment['id_pesanan']),
            'validation' => \Config\Services::validation(),
        ];
        return view('admin/pembayaran/edit', $data);
    }

    // [UPDATE] Memproses pembaruan pembayaran
    public function update($id = null)
    {
        $rules = [
            'jumlah' => 'required|numeric',
            'metode' => 'required|in_list[transfer_bank,tunai]',
            'status' => 'required|in_list[menunggu,lunas,gagal,dikembalikan]',
            'id_transaksi' => 'permit_empty',
            'tanggal_pembayaran' => 'permit_empty|valid_date'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pembayaranModel->update($id, $this->request->getPost());
        
        if ($this->request->getPost('status') === 'lunas') {
            $payment = $this->pembayaranModel->find($id);
            $this->pesananModel->update($payment['id_pesanan'], ['status' => 'dikonfirmasi']);
        } else {
            // Logika jika status diubah dari lunas ke yang lain (opsional)
            // Misalnya, ubah kembali status pesanan menjadi 'menunggu'
        }

        return redirect()->to('/admin/pembayaran')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    // [DELETE] Menghapus pembayaran
    public function delete($id = null)
    {
        $this->pembayaranModel->delete($id);
        return redirect()->to('/admin/pembayaran')->with('success', 'Data pembayaran berhasil dihapus.');
    }
}