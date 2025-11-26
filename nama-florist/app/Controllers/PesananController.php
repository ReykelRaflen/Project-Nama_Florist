<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\DetailPesananModel;
use App\Models\PapanBungaModel;
use App\Models\PembayaranModel;

class PesananController extends BaseController
{
    public function checkout($id)
    {
        $product = (new PapanBungaModel())->find($id);

        if (!$product) {
            return redirect()->to('/katalog')->with('error', 'Produk tidak ditemukan.');
        }

        return view('order/checkout', compact('product'));
    }

    public function process()
    {
        $productModel = new PapanBungaModel();
        $pesananModel = new PesananModel();
        $detailModel = new DetailPesananModel();

        $productId = $this->request->getPost('product_id');
        $durasi = $this->request->getPost('durasi');
        $jumlah = $this->request->getPost('jumlah');

        $product = $productModel->find($productId);

        if (!$product || $product['stok'] < $jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $subtotal = $product['harga'] * $jumlah * $durasi;

        // 1. Simpan Pesanan
        $orderId = $pesananModel->insert([
            'id_penyewa' => session()->get('user_id'),
            'tanggal_sewa' => $this->request->getPost('tanggal'),
            'total_harga' => $subtotal,
            'teks_pesan' => $this->request->getPost('teks_pesan'),
            'status' => 'pending'
        ]);


        // 2. Simpan Detail Pesanan
        $detailModel->insert([
            'id_pesanan' => $orderId,
            'id_papan_bunga' => $productId,
            'jumlah' => $jumlah,
            'harga' => $product['harga'],
            'subtotal' => $subtotal,
        ]);

        // 3. Kurangi Stok
        $productModel->update($productId, [
            'stok' => $product['stok'] - $jumlah
        ]);

        return redirect()->to("/order/confirm/$orderId");
    }

    public function confirm($id)
    {
        $pesananModel = new PesananModel();
        $detailModel = new DetailPesananModel();
        $productModel = new PapanBungaModel();

        $order = $pesananModel->find($id);
        $detail = $detailModel->where('id_pesanan', $id)->first();
        $product = $productModel->find($detail['id_papan_bunga']);

        return view('order/confirm', compact('order', 'product', 'detail'));
    }

    public function payment($id)
    {
        return view('order/payment', ['id' => $id]);
    }

    public function uploadPayment()
    {
        $paymentModel = new PembayaranModel();
        $orderId = $this->request->getPost('order_id');

        $paymentModel->insert([
            'id_pesanan' => $orderId,
            'jumlah' => $this->request->getPost('jumlah'),
            'metode' => 'transfer bank',
            'status' => 'menunggu verifikasi',
            'id_transaksi' => strtoupper(uniqid("PB-"))
        ]);

        return redirect()->to("/order/finish/$orderId");
    }

    public function finish($id)
    {
        return view('order/finish', ['orderId' => $id]);
    }
}
