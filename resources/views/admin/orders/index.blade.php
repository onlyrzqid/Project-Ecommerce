<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Masuk - Admin</title>
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

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">📦 Daftar Pesanan Masuk</h2>

            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-100 text-emerald-700 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-sm">
                            <th class="p-4">Kode Transaksi</th>
                            <th class="p-4">Pembeli</th>
                            <th class="p-4">Total Harga</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                        @forelse($orders as $order)
                            <tr>
                                <td class="p-4 font-bold text-indigo-600">{{ $order->kode_transaksi }}</td>
                                <td class="p-4">{{ $order->nama_penerima }}</td>
                                <td class="p-4">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $order->status == 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $order->status == 'diproses' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $order->status == 'selesai' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ $order->status == 'dibatalkan' ? 'bg-rose-100 text-rose-700' : '' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-slate-400">{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td class="p-4 text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg text-xs transition">
                                        Detail & Ubah Status
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-slate-400">Belum ada pesanan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </main>

    </div>
</body>
</html>