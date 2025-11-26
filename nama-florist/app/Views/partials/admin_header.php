<!-- app/Views/partials/admin_header.php -->
<?php
    $nama = session()->get('nama') ?? 'Admin';
    $parts = explode(' ', $nama);
    $initials = count($parts) > 1 ? strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1)) : strtoupper(substr($nama, 0, 2));
?>
<header class="h-16 w-full border-b border-gray-200 dark:border-gray-800 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm sticky top-0 z-40">
  <div class="h-full px-4 sm:px-6 md:px-8 flex items-center justify-between gap-4">
    <div class="flex items-center gap-3 lg:hidden">
      <span class="material-symbols-outlined text-3xl text-primary">local_florist</span>
      <h2 class="font-display text-lg font-bold text-primary">Admin Florist</h2>
    </div>
    <div class="flex-1 hidden md:flex relative max-w-md">
      <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-primary/70">search</span>
      <input class="form-input w-full rounded-full pl-10 h-10 bg-primary/10 border-0 focus:ring-2 focus:ring-primary/40" placeholder="Cari pesanan, pengguna, produk..." />
    </div>
    <div class="flex items-center gap-2">
      <button class="rounded-full h-9 w-9 flex items-center justify-center bg-primary/10 text-primary">
        <span class="material-symbols-outlined">notifications</span>
      </button>
      <div class="size-9 rounded-full bg-gradient-to-br from-primary/20 to-accent/30 flex items-center justify-center text-primary text-sm font-bold" title="<?= esc($nama) ?>">
        <?= $initials ?>
      </div>
    </div>
  </div>
</header>