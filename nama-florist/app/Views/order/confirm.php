<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<main class="px-6 py-8 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-4">Konfirmasi Pesanan</h2>

    <div class="space-y-3 text-lg">
        <p><strong>Produk:</strong> <?= esc($product['nama']) ?></p>
        <p><strong>Tanggal Sewa:</strong> <?= $order['tanggal_sewa'] ?></p>
        <p><strong>Total Harga:</strong> Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></p>
        <p><strong>Catatan:</strong> <?= esc($order['teks_pesan'] ?? '-') ?></p>
    </div>

    <form action="<?= site_url('order/finish/' . $order['id']) ?>" class="mt-5">
        <input type="hidden" name="order_id" value="<?= $order['id'] ?>" />

        <button class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700">
            Selesaikan Pesanan
        </button>
    </form>
</main>

<?= $this->endSection() ?>
