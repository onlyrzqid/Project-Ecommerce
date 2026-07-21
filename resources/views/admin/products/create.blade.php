<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - CompStore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans p-6">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
        <h1 class="text-xl font-bold text-slate-900 mb-6">Tambah Produk Baru</h1>
        <!-- Tambahkan blok pesan error ini -->
@if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-5 text-sm">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Produk</label>
                <input type="text" name="nama" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required placeholder="Contoh: ASUS ROG Zephyrus">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                    <select name="category_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:border-blue-500 bg-white" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stok Awal</label>
                    <input type="number" name="stok" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:border-blue-500" required min="0" placeholder="10">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Harga (Rupiah)</label>
                <input type="number" name="harga" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:border-blue-500" required min="0" placeholder="15000000">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Produk (Max 2MB)</label>
                <input type="file" name="foto" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Spesifikasi</label>
                <textarea name="deskripsi" rows="4" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:border-blue-500" placeholder="Tulis spesifikasi detail produk di sini..."></textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-medium transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700 shadow-sm transition">Simpan Produk</button>
            </div>
        </form>
    </div>
</body>
</html>