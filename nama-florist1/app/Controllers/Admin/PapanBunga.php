<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PapanBungaModel;

class PapanBunga extends BaseController
{
    protected $papanBungaModel;

    public function __construct()
    {
        $this->papanBungaModel = new PapanBungaModel();
        helper(['form', 'url']);
    }

    // [READ] Menampilkan semua produk dengan filter dan paginasi
    public function index()
    {
        $searchQuery = $this->request->getGet('search');
        $statusFilter = $this->request->getGet('status');

        $query = $this->papanBungaModel->orderBy('dibuat_pada', 'DESC');

        if ($searchQuery) {
            $query->like('nama', $searchQuery);
        }
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $data = [
            'products' => $query->paginate(8, 'products'),
            'pager' => $this->papanBungaModel->pager,
            'searchQuery' => $searchQuery,
            'statusFilter' => $statusFilter,
        ];
        return view('admin/papan_bunga/index', $data);
    }

    // [CREATE] Menampilkan form tambah produk
    public function new()
    {
        return view('admin/papan_bunga/new', [
            'validation' => \Config\Services::validation()
        ]);
    }

    // [CREATE] Memproses penambahan produk baru
    public function create()
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $fileGambar->getRandomName();
        $fileGambar->move('uploads/images', $namaGambar);

        $this->papanBungaModel->save([
            'nama' => $this->request->getPost('nama'),
            'ukuran' => $this->request->getPost('ukuran'),
            'bahan' => $this->request->getPost('bahan'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'status' => $this->request->getPost('status'),
            'gambar' => $namaGambar,
        ]);

        return redirect()->to('/admin/papanbunga')->with('success', 'Produk berhasil ditambahkan.');
    }

    // [UPDATE] Menampilkan form edit produk
    public function edit($id = null)
    {
        $product = $this->papanBungaModel->find($id);
        if (empty($product)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk dengan ID ' . $id . ' tidak ditemukan');
        }

        return view('admin/papan_bunga/edit', [
            'product' => $product,
            'validation' => \Config\Services::validation()
        ]);
    }

    // [UPDATE] Memproses pembaruan produk
    public function update($id = null)
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            // Saat validasi gagal, kita perlu mengirim ID kembali agar form bisa dibangun ulang
            return redirect()->to('admin/papanbunga/edit/' . $id)->withInput()->with('validation', $this->validator);
        }

        $oldProduct = $this->papanBungaModel->find($id);
        if (!$oldProduct) {
            return redirect()->to('/admin/papanbunga')->with('error', 'Produk tidak ditemukan.');
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'ukuran' => $this->request->getPost('ukuran'),
            'bahan' => $this->request->getPost('bahan'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'status' => $this->request->getPost('status'),
        ];

        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            if ($oldProduct['gambar'] && file_exists('uploads/images/' . $oldProduct['gambar'])) {
                unlink('uploads/images/' . $oldProduct['gambar']);
            }
            $namaGambarBaru = $fileGambar->getRandomName();
            $fileGambar->move('uploads/images', $namaGambarBaru);
            $data['gambar'] = $namaGambarBaru;
        }

        $this->papanBungaModel->update($id, $data);

        return redirect()->to('/admin/papanbunga')->with('success', 'Produk berhasil diperbarui.');
    }

    // [DELETE] Menghapus produk
    public function delete($id = null)
    {
        $product = $this->papanBungaModel->find($id);
        if ($product) {
            if ($product['gambar'] && file_exists('uploads/images/' . $product['gambar'])) {
                unlink('uploads/images/' . $product['gambar']);
            }
            $this->papanBungaModel->delete($id);
            return redirect()->to('/admin/papanbunga')->with('success', 'Produk berhasil dihapus.');
        }

        return redirect()->to('/admin/papanbunga')->with('error', 'Produk tidak ditemukan.');
    }
}