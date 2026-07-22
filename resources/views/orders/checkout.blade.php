<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan - RazaqComputer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 flex flex-col min-h-screen">

    <header class="bg-slate-900 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-xl text-blue-400">💻 RazaqComputer</a>
            <a href="{{ route('cart.index') }}" class="text-xs text-slate-300 hover:text-white">← Kembali ke Keranjang</a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-8 flex-1 w-full">
        <h1 class="text-2xl font-bold text-slate-900 mb-6">📦 Form Checkout Pesanan</h1>

        <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @csrf
            
            <!-- INFORMASI PENGIRIMAN -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h2 class="font-bold text-slate-900 text-lg border-b pb-2">Informasi Pengiriman</h2>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Nama Penerima</label>
                    <input type="text" name="nama_penerima" value="{{ auth()->user()->name }}" required class="w-full border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Nomor WhatsApp / HP</label>
                    <input type="text" name="no_hp" placeholder="081234567890" required class="w-full border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Alamat Lengkap</label>
                    <textarea name="alamat_pengiriman" rows="3" required placeholder="Jalan, No. Rumah, Kecamatan, Kota/Kabupaten" class="w-full border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="w-full border rounded-xl p-2.5 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="Transfer Bank (BCA)">Transfer Bank (BCA)</option>
                        <option value="Transfer Bank (Mandiri)">Transfer Bank (Mandiri)</option>
                        <option value="E-Wallet (Gopay/OVO)">E-Wallet (Gopay/OVO)</option>
                        <option value="COD (Bayar di Tempat)">COD (Bayar di Tempat)</option>
                    </select>
                </div>
            </div>

            <!-- RINCIAN PESANAN -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
                <div>
                    <h2 class="font-bold text-slate-900 text-lg border-b pb-2 mb-4">Rincian Barang</h2>
                    @php $total = 0; @endphp
                    <div class="space-y-3 mb-6 max-h-60 overflow-y-auto">
                        @foreach($carts as $item)
                            @php $total += $item->product->harga * $item->qty; @endphp
                            <div class="flex items-center justify-between text-sm">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $item->product->nama }}</p>
                                    <p class="text-xs text-slate-400">{{ $item->qty }} x Rp {{ number_format($item->product->harga, 0, ',', '.') }}</p>
                                </div>
                                <span class="font-bold text-slate-700">Rp {{ number_format($item->product->harga * $item->qty, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <hr class="my-4 border-slate-100">
                    <div class="flex justify-between items-center mb-6">
                        <span class="font-bold text-slate-600">Total Pembayaran</span>
                        <span class="font-extrabold text-blue-600 text-xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl text-sm transition shadow-md">
                        Buat Pesanan Sekarang
                    </button>
                </div>
            </div>
        </form>
    </main>

</body>
</html>