<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->nama }} - CompStore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <header class="bg-slate-900 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="font-bold text-xl tracking-wider text-blue-400 flex items-center gap-2">
                <span>💻</span> CompStore
            </a>
            
            <a href="{{ route('home') }}" class="text-xs text-slate-300 hover:text-white transition flex items-center gap-1">
                ← Kembali ke Katalog
            </a>
        </div>
    </header>

    <!-- CONTAINER DETAIL PRODUK -->
    <main class="max-w-6xl mx-auto px-4 py-8 flex-1 w-full flex items-center justify-center">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 md:p-10 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8 w-full items-start">
            
            <!-- 1. PERBAIKAN FOTO PRODUK (Proporsional & Tidak Memenuhi Layar) -->
            <div class="bg-slate-100 rounded-2xl p-4 border border-slate-200 flex items-center justify-center h-80 md:h-[400px] w-full overflow-hidden">
                @if($product->foto)
                    <img src="{{ asset('storage/' . $product->foto) }}" 
                         alt="{{ $product->nama }}" 
                         class="max-h-full max-w-full object-contain rounded-lg">
                @else
                    <div class="text-center text-slate-400">
                        <span class="text-5xl block mb-2">📷</span>
                        <span class="text-xs">Foto Tidak Tersedia</span>
                    </div>
                @endif
            </div>

            <!-- DETAIL & INFORMASI PRODUK -->
            <div class="flex flex-col justify-between h-full min-h-[380px]">
                <div>
                    <!-- Badge Kategori -->
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full inline-block mb-3">
                        {{ $product->category->nama }}
                    </span>
                    
                    <!-- Nama Produk -->
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900 mb-2 leading-tight">
                        {{ $product->nama }}
                    </h1>
                    
                    <!-- Harga -->
                    <p class="text-blue-600 font-extrabold text-3xl mb-4">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </p>
                    
                    <!-- Deskripsi -->
                    <div class="border-t border-b border-slate-100 py-4 my-4">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                            Deskripsi Spesifikasi
                        </h3>
                        <p class="text-slate-600 text-sm whitespace-pre-line leading-relaxed max-h-40 overflow-y-auto">
                            {{ $product->deskripsi ?? 'Tidak ada deskripsi spesifikasi untuk produk ini.' }}
                        </p>
                    </div>

                    <!-- Stok -->
                    <p class="text-sm text-slate-600 mb-6">
                        Sisa Stok Available: <strong class="text-slate-900 text-base">{{ $product->stok }} unit</strong>
                    </p>
                </div>

                <!-- 2. PERBAIKAN TOMBOL TAMBAH KERANJANG (Proporsional & Tegas) -->
                <div class="flex items-center gap-3 pt-2">
    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
        @csrf
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-2xl text-sm transition shadow-md hover:shadow-lg active:scale-[0.99] flex items-center justify-center gap-2">
            <span>🛒</span> + Tambah ke Keranjang
        </button>
    </form>
    
    <button type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-500 p-4 rounded-2xl transition flex items-center justify-center">
        ❤️
    </button>
</div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 text-xs text-center py-6 border-t border-slate-800">
        <p>&copy; {{ date('Y') }} CompStore E-Commerce. All rights reserved.</p>
    </footer>

</body>
</html>