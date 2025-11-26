<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Pesanan Berhasil
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="px-6 md:px-10 lg:px-20 flex-1 flex items-center justify-center py-10">
    <div class="text-center max-w-2xl">
        <div class="flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-8xl text-green-500">check_circle</span>
        </div>
        <h1 class="font-display text-4xl font-bold text-primary">Pesanan Anda Berhasil Dibuat!</h1>
        <p class="mt-4 text-lg text-gray-600">Terima kasih telah memesan. Nomor pesanan Anda adalah <strong>#<?= $pesananId ?></strong>. Kami telah mengirimkan detail pesanan dan instruksi pembayaran ke email Anda.</p>
        <div class="mt-8 flex justify-center gap-4">
            <a href="<?= site_url('/') ?>" class="h-11 px-6 rounded-full bg-primary/10 text-primary font-bold hover:bg-primary/20 transition">Kembali ke Beranda</a>
            <a href="<?= site_url('my-orders/' . $pesananId) ?>" class="h-11 px-6 rounded-full bg-primary text-white font-bold hover:bg-primary/90 transition">Lihat Riwayat Pesanan</a>
        </div>
    </div>
</main>
<?= $this->endSection() ?>