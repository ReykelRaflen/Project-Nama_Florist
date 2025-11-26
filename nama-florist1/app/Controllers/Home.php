<?php

namespace App\Controllers;

use App\Models\PapanBungaModel;

class Home extends BaseController
{
    protected $papanBungaModel;

    public function __construct()
    {
        $this->papanBungaModel = new PapanBungaModel();
        helper(['form']);
    }

    // [BARU] Fungsi untuk Homepage
    public function index()
    {
        $data = [
            // Ambil 3 produk terbaru/pilihan yang statusnya 'tersedia'
            'featuredProducts' => $this->papanBungaModel
                ->where('status', 'tersedia')
                ->orderBy('dibuat_pada', 'DESC')
                ->limit(3)
                ->findAll(),
        ];
        return view('homepage', $data);
    }

    // app/Controllers/Home.php -> fungsi katalog() sudah benar
    public function katalog()
    {
        $data = [
            'products' => $this->papanBungaModel
                ->where('status', 'tersedia')
                ->orderBy('dibuat_pada', 'DESC')
                ->paginate(12, 'products'), // Anda bisa sesuaikan jumlah item per halaman
            'pager' => $this->papanBungaModel->pager,
        ];
        return view('katalog', $data);
    }

    // Fungsi detail produk tetap sama
    public function show($id = null)
    {
        $product = $this->papanBungaModel->find($id);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Ambil 4 produk lain secara acak, yang bukan produk saat ini
        $relatedProducts = $this->papanBungaModel
            ->where('id !=', $id)
            ->where('status', 'tersedia')
            ->orderBy('RAND()') // Ambil secara acak
            ->limit(4)
            ->findAll();

        $data = [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ];

        return view('detail_produk', $data);
    }
}