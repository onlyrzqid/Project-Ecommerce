<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - CompStore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans text-slate-800">
    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        <aside class="w-64 bg-slate-900 text-slate-300 p-5 hidden md:block flex-shrink-0">
            <div class="font-bold text-white text-xl mb-8 tracking-wider">💻 CompStore</div>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">📊 Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-2.5 rounded-xl bg-blue-600 text-white font-medium shadow-md shadow-blue-900/30">📦 CRUD Produk</a>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Manajemen Stok Produk</h1>
                    <p class="text-sm text-slate-500">Kelola katalog laptop dan aksesoris toko Anda.</p>
                </div>
                <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-medium shadow-sm transition">+ Tambah Produk</a>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- TABLE CONTAINER -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4">Foto</th>
                            <th class="p-4">Nama Produk</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4">Harga</th>
                            <th class="p-4">Stok</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($products as $product)
                        <tr>
                            <td class="p-4">
                                @if($product->foto)
                                    <img src="{{ asset('storage/' . $product->foto) }}" class="w-12 h-12 rounded-xl object-cover border">
                                @else
                                    <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-[10px] text-slate-400">No Img</div>
                                @endif
                            </td>
                            <td class="p-4 font-semibold text-slate-900">{{ $product->nama }}</td>
                            <td class="p-4">
                                <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md text-xs font-medium">{{ $product->category->nama }}</span>
                            </td>
                            <td class="p-4 font-medium">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td class="p-4">{{ $product->stok }} unit</td>
                            <td class="p-4 flex justify-center space-x-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition font-medium">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg transition font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">Belum ada produk terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4 border-t border-slate-100">
                    {{ $products->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>