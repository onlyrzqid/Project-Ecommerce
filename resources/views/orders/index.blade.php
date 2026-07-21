<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan Saya - CompStore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 flex flex-col min-h-screen">

    <header class="bg-slate-900 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-xl text-blue-400">💻 CompStore</a>
            <a href="{{ route('home') }}" class="text-xs text-slate-300 hover:text-white">← Kembali ke Katalog</a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8 flex-1 w-full">
        <h1 class="text-2xl font-bold text-slate-900 mb-6">📜 Riwayat Pesanan Saya</h1>

        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 text-sm p-4 rounded-2xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <div class="flex flex-wrap items-center justify-between border-b pb-4 mb-4 gap-2">
                            <div>
                                <span class="font-mono text-xs font-bold text-blue-600">{{ $order->kode_transaksi }}</span>
                                <span class="text-xs text-slate-400 ml-2">{{ $order->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <span class="text-xs font-bold px-3 py-1 rounded-full uppercase bg-amber-100 text-amber-800">
                                {{ $order->status }}
                            </span>
                        </div>

                        <div class="space-y-3 mb-4">
                            @foreach($order->items as $item)
                                <div class="flex justify-between text-sm">
                                    <span>{{ $item->product->nama }} (x{{ $item->qty }})</span>
                                    <span class="font-semibold">Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t pt-4 flex justify-between items-center">
                            <span class="text-xs text-slate-500">Metode: {{ $order->metode_pembayaran }}</span>
                            <div class="text-right">
                                <span class="text-xs text-slate-500 block">Total Transaksi</span>
                                <span class="font-bold text-blue-600 text-base">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                <span class="text-5xl block mb-3">📦</span>
                <p class="text-slate-500 font-medium text-sm">Belum ada riwayat pesanan.</p>
            </div>
        @endif
    </main>

</body>
</html>