<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Manajemen Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="flex items-center justify-between gap-4 mb-6">
        <h1 class="font-display text-2xl md:text-3xl font-bold text-primary">Manajemen Pengguna</h1>
        <!-- Tombol "Tambah Pengguna" sekarang mengarah ke halaman baru -->
        <a href="<?= site_url('admin/pengguna/new') ?>" class="inline-flex items-center gap-2 rounded-lg h-11 px-5 bg-primary text-white text-sm font-bold hover:bg-primary/90">
            <span class="material-symbols-outlined">person_add</span>
            Tambah Pengguna
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if(session()->has('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
            <!-- Menampilkan error validasi jika redirect dari create/update -->
        </div>
    <?php endif; ?>

    <!-- Filters -->
    <section class="rounded-xl border border-gray-200 p-4 mb-6 bg-background-light">
        <form action="<?= site_url('admin/pengguna') ?>" method="get">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <label class="flex flex-col">
                    <span class="text-sm mb-1">Cari</span>
                    <input name="search" class="form-input rounded-lg" placeholder="Nama / Email / Telepon" value="<?= esc($search ?? '') ?>" />
                </label>
                <label class="flex flex-col">
                    <span class="text-sm mb-1">Role</span>
                    <select name="role" class="form-select rounded-lg">
                        <option value="">Semua</option>
                        <option value="penyewa" <?= ($role ?? '') == 'penyewa' ? 'selected' : '' ?>>Penyewa</option>
                        <option value="admin" <?= ($role ?? '') == 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </label>
                <div class="flex gap-2">
                    <button type="submit" class="w-full h-11 px-5 rounded-lg bg-primary text-white font-bold hover:bg-primary/90">Filter</button>
                    <a href="<?= site_url('admin/pengguna') ?>" class="w-full h-11 px-5 rounded-lg border flex items-center justify-center">Reset</a>
                </div>
            </div>
        </form>
    </section>

    <!-- Table -->
    <section class="rounded-xl border border-gray-200 overflow-hidden bg-background-light">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-primary/10">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">User ID</th>
                        <th class="px-4 py-3 text-left font-semibold">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold">Email</th>
                        <th class="px-4 py-3 text-left font-semibold">Telepon</th>
                        <th class="px-4 py-3 text-left font-semibold">Tanggal Daftar</th>
                        <th class="px-4 py-3 text-left font-semibold">Role</th>
                        <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (!empty($users)): ?>
                        <?php foreach($users as $u): ?>
                        <tr>
                            <td class="px-4 py-3">#<?= $u['id'] ?></td>
                            <td class="px-4 py-3 font-semibold"><?= esc($u['nama']) ?></td>
                            <td class="px-4 py-3"><?= esc($u['email']) ?></td>
                            <td class="px-4 py-3"><?= esc($u['telepon'] ?: '-') ?></td>
                            <td class="px-4 py-3"><?= date('d M Y, H:i', strtotime($u['dibuat_pada'])) ?></td>
                            <td class="px-4 py-3"><span class="px-2 py-0-5 rounded-full text-xs font-semibold <?= $u['peran'] == 'admin' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-200 text-gray-800' ?>"><?= ucfirst($u['peran']) ?></span></td>
                            <td class="px-4 py-3 text-right">
                                <!-- Tombol Ubah sekarang menjadi link ke halaman edit -->
                                <a href="<?= site_url('admin/pengguna/' . $u['id'] . '/edit') ?>" class="text-primary hover:underline">Ubah</a>
                                <!-- Form Hapus tetap sama -->
                                <form action="<?= site_url('admin/pengguna/' . $u['id']) ?>" method="post" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-red-600 hover:underline ml-3">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center p-4">Tidak ada data pengguna ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t text-sm">
            <?= $pager->links('users', 'tailwind_pagination') ?>
        </div>
    </section>
</div>
<?= $this->endSection() ?>