<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RazaqComputer - Toko Laptop & Aksesoris Terpercaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <header class="bg-slate-900 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <!-- LOGO -->
            <a href="{{ route('home') }}" class="font-bold text-xl tracking-wider text-blue-400 flex items-center gap-2">
                <span>💻</span> RazaqComputer
            </a>

            <!-- SEARCH BAR -->
            <form action="{{ route('home') }}" method="GET" class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laptop, mouse, keyboard..." class="w-full bg-slate-800 text-sm text-white placeholder-slate-400 rounded-full py-2 pl-4 pr-10 outline-none focus:ring-2 focus:ring-blue-500 border border-slate-700">
                    <button type="submit" class="absolute right-3 top-2.5 text-slate-400 hover:text-white">🔍</button>
                </div>
            </form>

            <!-- NAVIGATION BUTTONS -->
            <div class="flex items-center gap-4 text-sm font-medium">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition">Panel Admin</a>
                    @else
                        <span class="text-slate-300">Halo, {{ auth()->user()->name }}</span>
                    
                    <!-- TOMBOL KERANJANG BELANJA -->
                    <a href="{{ route('cart.index') }}" class="text-slate-300 hover:text-white transition">
                    🛒 Keranjang
                    </a>

                    <!-- TOMBOL PESANAN SAYA (LANGKAH 7) -->
                    <a href="{{ route('orders.index') }}" class="text-slate-300 hover:text-white transition">
                    📜 Pesanan Saya
                    </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-400 hover:text-red-300">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-300 hover:text-white">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO BANNER -->
    <section class="bg-slate-900 text-white py-10 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-3">Temukan Laptop & Akesosris Impianmu</h1>
            <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto">Pusat belanja laptop, dan aksesoris terlengkap dengan harga bersaing dan garansi resmi.</p>
        </div>
    </section>

    <!-- KATALOG PRODUK -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1 w-full">
        
        <!-- FILTER KATEGORI -->
        <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-6 border-b border-slate-200">
            <a href="{{ route('home') }}" class="px-4 py-2 rounded-full text-xs font-semibold whitespace-nowrap {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-white border text-slate-600 hover:bg-slate-100' }}">
                Semua Produk
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('home', ['category' => $cat->id, 'search' => request('search')]) }}" class="px-4 py-2 rounded-full text-xs font-semibold whitespace-nowrap {{ request('category') == $cat->id ? 'bg-blue-600 text-white' : 'bg-white border text-slate-600 hover:bg-slate-100' }}">
                    {{ $cat->nama }}
                </a>
            @endforeach
        </div>

        <!-- GRID PRODUK -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                        <div class="h-48 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                            @if($product->foto)
                                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-slate-400 text-xs">Foto Tidak Tersedia</span>
                            @endif
                            <span class="absolute top-3 left-3 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">
                                {{ $product->category->nama }}
                            </span>
                        </div>

                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-slate-900 text-base line-clamp-1 mb-1">{{ $product->nama }}</h3>
                                <p class="text-slate-500 text-xs line-clamp-2 mb-3">{{ $product->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                            </div>
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-blue-600 font-extrabold text-lg">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                    <span class="text-xs text-slate-400">Stok: {{ $product->stok }}</span>
                                </div>
                                <a href="{{ route('products.show', $product->id) }}" class="block w-full text-center bg-slate-900 hover:bg-blue-600 text-white py-2 rounded-xl text-xs font-bold transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl border border-slate-200">
                <span class="text-4xl block mb-2">💻</span>
                <p class="text-slate-500 font-medium text-sm">Produk tidak ditemukan.</p>
            </div>
        @endif
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 text-xs text-center py-6 border-t border-slate-800">
        <p>&copy; {{ date('Y') }} RazaqComputer E-Commerce. All rights reserved.</p>
    </footer>

</body>
</html>