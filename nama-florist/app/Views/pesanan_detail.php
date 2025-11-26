<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Detail Pesanan #<?= $order['id'] ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="px-6 md:px-10 lg:px-20 flex-1 justify-center py-10">
    <div class="flex flex-col max-w-7xl mx-auto">
        <div class="flex flex-col gap-4 mb-8">
            <p class="text-primary dark:text-accent text-4xl lg:text-5xl font-black font-display">
                Detail Pesanan
            </p>
            <p class="text-text-light/80 text-base">
                Status Pesanan Anda:
                <span
                    class="font-bold px-2 py-1 rounded-full text-xs <?= ($order['status'] == 'selesai' || $order['status'] == 'dikonfirmasi') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                    <?= ucfirst(str_replace('_', ' ', $order['status'])) ?>
                </span>
            </p>
        </div>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                <p class="font-bold">Berhasil!</p>
                <p><?= session()->getFlashdata('success') ?></p>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left: Order Items -->
            <section class="lg:col-span-2">
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-primary/10 dark:bg-accent/10">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left font-semibold">Produk</th>
                                <th scope="col" class="px-4 py-3 text-left font-semibold">Harga</th>
                                <th scope="col" class="px-4 py-3 text-left font-semibold">Jumlah</th>
                                <th scope="col" class="px-4 py-3 text-left font-semibold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <img class="w-16 h-16 rounded-lg object-cover"
                                            src="<?= base_url('uploads/images/' . $order['gambar_produk']) ?>"
                                            alt="<?= esc($order['nama_produk']) ?>" />
                                        <div>
                                            <p class="font-medium"><?= esc($order['nama_produk']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex items-center justify-center w-12 h-9 rounded-lg border">1</span>
                                </td>
                                <td class="px-4 py-4 font-semibold">Rp
                                    <?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <a href="<?= site_url('/katalog') ?>"
                        class="text-sm text-primary dark:text-accent hover:underline">Kembali ke Katalog</a>
                </div>
            </section>

            <!-- Right: Order Summary -->
            <aside class="lg:col-span-1">
                <div
                    class="sticky top-28 border border-gray-200 dark:border-gray-700 rounded-xl p-6 bg-background-light dark:bg-background-dark/50 shadow-lg">
                    <h3 class="text-primary dark:text-accent text-xl font-bold mb-6 font-display">Ringkasan Pesanan</h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-text-light/80">ID Pesanan:</span>
                            <span class="font-semibold font-mono">#<?= $order['id'] ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-light/80">Tanggal Pesan:</span>
                            <span class="font-semibold"><?= date('d M Y', strtotime($order['tanggal_pesan'])) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-light/80">Tanggal Sewa:</span>
                            <span class="font-semibold"><?= date('d M Y', strtotime($order['tanggal_sewa'])) ?></span>
                        </div>
                    </div>
                    <div class="border-t border-dashed border-gray-200 dark:border-gray-700 my-6"></div>
                    <div class="space-y-3">
                        <div class="flex justify-between text-text-light/80">
                            <span>Subtotal</span>
                            <span>Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></span>
                        </div>
                        <div class="flex justify-between font-bold text-lg text-text-light dark:text-text-dark">
                            <span>Total</span>
                            <span>Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 my-6"></div>

                    <?php if ($order['status'] == 'menunggu'): ?>
                        <a href="#"
                            class="w-full inline-flex items-center justify-center overflow-hidden rounded-lg h-12 px-4 bg-primary text-white font-bold hover:bg-primary/90">
                            <span class="material-symbols-outlined mr-2">payment</span>
                            <span class="truncate">Lakukan Pembayaran</span>
                        </a>
                    <?php else: ?>
                        <div class="text-center p-3 rounded-lg bg-green-100 text-green-800">
                            <p class="font-semibold">Pembayaran Dikonfirmasi</p>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </div>
</main>
<?= $this->endSection() ?>