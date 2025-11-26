<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="text-center py-20">
    <h1 class="text-3xl font-bold text-green-600">Pesanan Berhasil!</h1>
    <p class="mt-3 text-gray-600">Pesanan Anda telah dicatat dan sedang diproses.</p>

    <a href="<?= site_url('/') ?>" class="mt-6 inline-block bg-primary text-white px-6 py-3 rounded-lg">
        Kembali ke Beranda
    </a>
</div>

<?= $this->endSection() ?>
