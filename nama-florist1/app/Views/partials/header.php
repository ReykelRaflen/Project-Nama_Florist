<!-- app/Views/partials/header.php (Versi Lengkap dengan Dropdown) -->
<header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm w-full">
    <div class="w-full px-4 sm:px-6 md:px-8 lg:px-10">
        <div
            class="flex items-center justify-between whitespace-nowrap border-b border-solid border-primary/20 dark:border-accent/20 py-4">

            <!-- Bagian Kiri (Logo & Navigasi) -->
            <div class="flex items-center gap-8">
                <a href="<?= site_url('/') ?>" class="flex items-center gap-3 text-primary dark:text-accent">
                    <span class="material-symbols-outlined text-3xl">local_florist</span>
                    <h2 class="text-xl font-bold font-display tracking-wide">Nama Florist</h2>
                </a>
                <nav class="hidden md:flex items-center gap-9">
                    <a class="text-sm font-medium leading-normal <?= (uri_string() == '/') ? 'text-primary dark:text-accent' : 'hover:text-primary dark:hover:text-accent transition-colors' ?>"
                        href="<?= site_url('/') ?>">Beranda</a>
                    <a class="text-sm font-medium leading-normal <?= (strpos(uri_string(), 'katalog') !== false) ? 'text-primary dark:text-accent' : 'hover:text-primary dark:hover:text-accent transition-colors' ?>"
                        href="<?= site_url('katalog') ?>">Katalog</a>
                    <a class="text-sm font-medium leading-normal hover:text-primary dark:hover:text-accent transition-colors"
                        href="#">Cara Pesan</a>
                    <a class="text-sm font-medium leading-normal hover:text-primary dark:hover:text-accent transition-colors"
                        href="#">Kontak</a>
                </nav>
            </div>

            <!-- Bagian Kanan (Tombol Aksi Dinamis) -->
            <div class="flex flex-1 justify-end items-center gap-2 md:gap-4">

                <?php if (session()->get('isLoggedIn')): ?>

                    <!-- [START] JIKA PENGGUNA SUDAH LOGIN -->
                    <div x-data="{ open: false }" class="relative">
                        <!-- Tombol Profil -->
                        <button @click="open = !open"
                            class="flex items-center justify-center rounded-full h-10 w-10 bg-primary/10 dark:bg-accent/10 text-primary dark:text-accent">
                            <span class="material-symbols-outlined">person</span>
                        </button>

                        <!-- Panel Dropdown -->
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 origin-top-right rounded-lg bg-background-light dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            style="display: none;">
                            <div class="py-1">
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-text-light dark:text-text-dark hover:bg-gray-100 dark:hover:bg-gray-700">Profil
                                    Saya</a>
                                <a href="<?= site_url('my-orders') ?>"
                                    class="block px-4 py-2 text-sm text-text-light dark:text-text-dark hover:bg-gray-100 dark:hover:bg-gray-700">Riwayat
                                    Pesanan</a>
                                <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                <a href="<?= site_url('logout') ?>"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">Logout</a>
                            </div>
                        </div>
                    </div>
                    <!-- [END] JIKA PENGGUNA SUDAH LOGIN -->

                <?php else: ?>

                    <!-- [START] JIKA PENGGUNA BELUM LOGIN -->
                    <a href="<?= site_url('login') ?>"
                        class="hidden sm:inline-flex items-center justify-center gap-2 rounded-full h-10 px-4 text-sm font-semibold hover:bg-primary/10 dark:hover:bg-accent/10">
                        Masuk
                    </a>
                    <a href="<?= site_url('register') ?>"
                        class="inline-flex items-center justify-center gap-2 rounded-full h-10 px-5 bg-primary text-white text-sm font-bold hover:bg-primary/90">
                        Daftar
                    </a>
                    <!-- [END] JIKA PENGGUNA BELUM LOGIN -->

                <?php endif; ?>

                <!-- Tombol Menu Mobile -->
                <button
                    class="md:hidden flex items-center justify-center rounded-full h-10 w-10 bg-primary/10 dark:bg-accent/10 text-primary dark:text-accent">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
    </div>
</header>