<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan {{ $order->kode_transaksi }} - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans text-slate-800">
    <div class="flex min-h-screen">
        
        <!-- SIDEBAR ADMIN UNIFORM -->
        <aside class="w-64 bg-slate-900 text-slate-300 p-5 block flex-shrink-0 min-h-screen">
            <div class="flex items-center space-x-3 mb-8 px-2">
                <span class="text-2xl">💻</span>
                <h1 class="text-xl font-bold text-white tracking-wide">RazaqComputer</h1>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800' }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800' }}">
                    <span>📦</span>
                    <span>CRUD Produk</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.orders.*') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800' }}">
                    <span>🛒</span>
                    <span>Pesanan Masuk</span>
                </a>

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
            <div class="flex justify-between items-center mb-6">
                <div>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 hover:underline font-medium">← Kembali ke Pesanan Masuk</a>
                    <h2 class="text-2xl font-bold text-slate-800 mt-1">Detail Pesanan: {{ $order->kode_transaksi }}</h2>
                </div>
            </div>

            {{-- Alert Notifikasi --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-100 text-emerald-700 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-rose-100 text-rose-700 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Rincian Produk & Pembeli (Kiri - 2 Kolom) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informasi Penerima -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                        <h3 class="font-bold text-slate-800 text-lg mb-4 pb-2 border-b">Informasi Penerima</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-slate-400">Nama Penerima</p>
                                <p class="font-semibold text-slate-700">{{ $order->nama_penerima }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400">Nomor Telepon</p>
                                <p class="font-semibold text-slate-700">{{ $order->no_hp ?? '-' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-slate-400">Alamat Pengiriman</p>
                                <p class="font-semibold text-slate-700">{{ $order->alamat_pengiriman ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Item Produk -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                        <h3 class="font-bold text-slate-800 text-lg mb-4 pb-2 border-b">Produk yang Dibeli</h3>
                        <div class="divide-y divide-slate-100">
                            @foreach($order->items ?? $order->orderItems ?? [] as $item)
                                <div class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $item->product->nama ?? 'Produk Dihapus' }}</p>
                                        <p class="text-xs text-slate-400">{{ $item->qty }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="font-bold text-slate-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="pt-4 mt-4 border-t flex justify-between items-center font-bold text-slate-800 text-lg">
                            <span>Total Pembayaran</span>
                            <span class="text-indigo-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Form Ubah Status Pesanan (Kanan - 1 Kolom) -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                        <h3 class="font-bold text-slate-800 text-lg mb-4 pb-2 border-b">Ubah Status Pesanan</h3>
                        
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" id="formUpdateStatus">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label for="statusSelect" class="block mb-2 text-sm font-medium text-slate-700">Status Transaksi</label>
                                <select name="status" id="statusSelect" class="w-full p-2.5 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm">
                                    <option value="pending" {{ strtolower($order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="diproses" {{ strtolower($order->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ strtolower($order->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan" {{ strtolower($order->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition shadow-sm hover:shadow">
                                Update Status Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div> 
        </main>
    </div>

    <!-- 1. Panggil CDN SweetAlert2 di bagian atas file (di dalam tag <head>) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- 2. Ganti script konfirmasi lama di bagian bawah file dengan ini: -->
<script>
    document.getElementById('formUpdateStatus').addEventListener('submit', function(e) {
        const form = this;
        const selectedStatus = document.getElementById('statusSelect').value.toLowerCase();

        // Konfirmasi SweetAlert2 untuk 'Selesai'
        if (selectedStatus === 'selesai' || selectedStatus === 'berhasil') {
            e.preventDefault(); // Hentikan form terkirim otomatis

            Swal.fire({
                title: 'Konfirmasi Selesai',
                text: 'Apakah Anda yakin ingin menyelesaikan pesanan ini? Status yang sudah Selesai tidak dapat diubah kembali.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5', // Warna Indigo
                cancelButtonColor: '#94a3b8',  // Warna Slate
                confirmButtonText: 'Ya, Selesaikan!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-4 py-2',
                    cancelButton: 'rounded-xl px-4 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Kirim form jika tombol 'Ya' diklik
                }
            });
        } 
        // Konfirmasi SweetAlert2 untuk 'Dibatalkan'
        else if (selectedStatus === 'dibatalkan') {
            e.preventDefault(); // Hentikan form terkirim otomatis

            Swal.fire({
                title: 'Konfirmasi Pembatalan',
                text: 'Apakah Anda yakin ingin MEMBATALKAN pesanan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Warna Merah
                cancelButtonColor: '#94a3b8',  // Warna Slate
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-4 py-2',
                    cancelButton: 'rounded-xl px-4 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Kirim form jika tombol 'Ya' diklik
                }
            });
        }
        // Jika status 'pending' atau 'diproses', form langsung terkirim tanpa alert
    });
</script>
</body>
</html>