<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - CompStore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <header class="bg-slate-900 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-xl text-blue-400 flex items-center gap-2">
                <span>💻</span> CompStore
            </a>
            <a href="{{ route('home') }}" class="text-xs text-slate-300 hover:text-white transition">← Lanjut Belanja</a>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="max-w-5xl mx-auto px-4 py-8 flex-1 w-full">
        <h1 class="text-2xl font-bold text-slate-900 mb-6">🛒 Keranjang Belanja Anda</h1>

        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 text-sm p-4 rounded-2xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($carts->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- LIST ITEM KERANJANG -->
                <div class="lg:col-span-2 space-y-4">
                    @php $subtotal = 0; @endphp
                    @foreach($carts as $item)
                        @php $subtotal += $item->product->harga * $item->qty; @endphp
                        <div class="bg-white rounded-2xl p-4 border border-slate-200 flex items-center gap-4 shadow-sm">
                            
                            <!-- Foto Produk -->
                            <div class="w-20 h-20 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 flex items-center justify-center border border-slate-200">
                                @if($item->product->foto)
                                    <img src="{{ asset('storage/' . $item->product->foto) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs text-slate-400">No Image</span>
                                @endif
                            </div>

                            <!-- Detail Produk & Form Qty -->
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-900 text-sm mb-1">{{ $item->product->nama }}</h3>
                                <p class="text-blue-600 font-extrabold text-sm mb-2">Rp {{ number_format($item->product->harga, 0, ',', '.') }}</p>
                                
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <span class="text-xs text-slate-500">Qty:</span>
                                    <input type="number" name="qty" value="{{ $item->qty }}" min="1" max="{{ $item->product->stok }}" class="w-16 text-center border border-slate-300 rounded-lg py-1 text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    <button type="submit" class="text-xs text-blue-600 hover:underline font-semibold">Update</button>
                                </form>
                            </div>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold p-2 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <!-- RINGKASAN HARGA -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Ringkasan Pesanan</h2>
                    <div class="flex justify-between text-sm text-slate-600 mb-2">
                        <span>Total Harga</span>
                        <span class="font-bold text-slate-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <hr class="my-4 border-slate-100">
                    <a href="{{ route('checkout.index') }}" class="block text-center w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-sm transition shadow-md">
                     Lanjut ke Checkout
                    </a>
                </div>

            </div>
        @else
            <!-- KERANJANG KOSONG -->
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                <span class="text-5xl block mb-3">🛒</span>
                <p class="text-slate-500 font-medium text-sm mb-4">Keranjang belanja Anda masih kosong.</p>
                <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition inline-block">
                    Mulai Belanja Sekarang
                </a>
            </div>
        @endif
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 text-xs text-center py-6 border-t border-slate-800">
        <p>&copy; {{ date('Y') }} RazaqComputer E-Commerce. All rights reserved.</p>
    </footer>

</body>
</html>
