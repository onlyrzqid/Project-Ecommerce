<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - CompStore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans text-slate-800">
    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        <aside class="w-64 bg-slate-900 text-slate-300 p-5 hidden md:block flex-shrink-0">
            <div class="font-bold text-white text-xl mb-8 tracking-wider">💻 CompStore</div>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-xl bg-blue-600 text-white font-medium shadow-md shadow-blue-900/30">📊 Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 hover:text-white transition">📦 CRUD Produk</a>
                <form method="POST" action="{{ route('logout') }}" class="pt-4">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2.5 rounded-xl text-red-400 hover:bg-red-500/10 transition font-medium">🚪 Keluar</button>
                </form>
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
                <!-- Total Penjualan -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Penjualan</p>
                    <p class="text-2xl font-extrabold text-slate-900 mt-2">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
                    <div class="absolute right-4 bottom-4 bg-blue-50 text-blue-600 p-2 rounded-xl text-xl font-bold">💰</div>
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