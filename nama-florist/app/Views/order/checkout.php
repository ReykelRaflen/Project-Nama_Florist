<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<main class="max-w-3xl mx-auto px-6 py-8">

    <h2 class="text-3xl font-bold mb-4">Checkout Pesanan</h2>

    <div class="bg-white shadow-md rounded-lg p-5 mb-6">
        <h3 class="text-xl font-semibold mb-2"><?= esc($product['nama']) ?></h3>
        <p class="text-gray-700 mb-2">Harga: <span class="font-semibold">Rp <?= number_format($product['harga'], 0, ',', '.') ?></span></p>
        <p class="text-gray-600">Stok tersedia: <?= $product['stok'] ?></p>
    </div>

    <form action="<?= site_url('order/process') ?>" method="POST" class="space-y-4">

        <?= csrf_field() ?>
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <input type="hidden" name="jumlah" value="1"> <!-- otomatis -->

        <div>
            <label class="font-semibold">Tanggal Sewa</label>
            <input type="date" name="tanggal" required class="w-full border rounded p-2">
        </div>

        <div>
            <label class="font-semibold">Durasi (Hari)</label>
            <input type="number" name="durasi" min="1" value="1" required class="w-full border rounded p-2">
        </div>

        <div>
            <label class="font-semibold">Tulisan Pada Papan</label>
            <textarea name="teks_pesan" class="w-full border rounded p-2" placeholder="Contoh: Selamat & sukses acara pernikahan..."></textarea>
        </div>

        <button class="w-full bg-yellow-500 text-white py-3 rounded-lg hover:bg-yellow-600 font-semibold">
            Konfirmasi Pesanan
        </button>
    </form>
</main>

<?= $this->endSection() ?>
