<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - RazaqComputer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans text-slate-800">
    <div class="flex min-h-screen">

        <!-- SIDEBAR ADMIN UNIFORM -->
<aside class="w-64 bg-slate-900 text-slate-300 p-5 block flex-shrink-0 min-h-screen">
    <!-- Logo / Brand Header -->
    <div class="flex items-center space-x-3 mb-8 px-2">
        <span class="text-2xl">💻</span>
        <h1 class="text-xl font-bold text-white tracking-wide">RazaqComputer</h1>
    </div>

    <!-- Navigasi Menu -->
    <nav class="space-y-2">
        <!-- 1. Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800' }}">
            <span>📊</span>
            <span>Dashboard</span>
        </a>

        <!-- 2. CRUD Produk -->
        <a href="{{ route('admin.products.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800' }}">
            <span>📦</span>
            <span>CRUD Produk</span>
        </a>

        <!-- 3. Pesanan Masuk -->
        <a href="{{ route('admin.orders.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.orders.*') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800' }}">
            <span>🛒</span>
            <span>Pesanan Masuk</span>
        </a>

        <!-- 4. Tombol Keluar -->
        <div class="pt-6 mt-6 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-rose-400 hover:bg-rose-500/10 transition">
                    <span>🚪</span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </nav>
</aside>

        <!-- CONTENT AREA -->
        <main class="flex-1 p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">Selamat Datang, Admin!</h1>
                <p class="text-sm text-slate-500">Berikut ringkasan transaksi dan performa toko komputer Anda hari ini.</p>
            </div>
            
            <!-- METRIC CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <!-- KARTU TOTAL PENJUALAN -->
<div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
    <div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Penjualan</p>
        <h3 class="text-2xl font-extrabold text-slate-900">
            Rp {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}
        </h3>
    </div>
    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-between justify-center text-xl">
        💰
    </div>
</div>

                <!-- Jumlah Order -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jumlah Order</p>
                    <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $jumlahOrder }} Pesanan</p>
                    <div class="absolute right-4 bottom-4 bg-amber-50 text-amber-600 p-2 rounded-xl text-xl font-bold">🛒</div>
                </div>

                <!-- Produk Terlaris -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Produk Terlaris</p>
                    <p class="text-base font-bold text-slate-900 mt-2 truncate max-w-[85%]">
                        {{ $produkTerlaris ? $produkTerlaris->nama : 'Belum Ada Data' }}
                    </p>
                    @if($produkTerlaris)
                        <span class="text-xs text-slate-400 block mt-0.5">Terjual: {{ $produkTerlaris->total_terjual }} unit</span>
                    @endif
                    <div class="absolute right-4 bottom-4 bg-emerald-50 text-emerald-600 p-2 rounded-xl text-xl font-bold">🔥</div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm text-center">
                <p class="text-slate-500 text-sm">Sistem terhubung sepenuhnya. Silakan gunakan menu samping untuk mengelola stok produk.</p>
            </div>
        </main>
    </div>
</body>
</html>