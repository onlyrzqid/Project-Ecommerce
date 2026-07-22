<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - RazaqComputer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans p-6">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
        <h1 class="text-xl font-bold text-slate-900 mb-6">Form Edit Produk</h1>
        
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Produk</label>
                <input type="text" name="nama" value="{{ $product->nama }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:border-blue-500" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                    <select name="category_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:border-blue-500 bg-white" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stok Barang</label>
                    <input type="number" name="stok" value="{{ $product->stok }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:border-blue-500" required min="0">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Harga (Rupiah)</label>
                <input type="number" name="harga" value="{{ $product->harga }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:border-blue-500" required min="0">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ganti Foto Produk (Biarkan kosong jika tidak diubah)</label>
                @if($product->foto)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $product->foto) }}" class="w-20 h-20 object-cover rounded-xl border">
                    </div>
                @endif
                <input type="file" name="foto" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Spesifikasi</label>
                <textarea name="deskripsi" rows="4" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:border-blue-500">{{ $product->deskripsi }}</textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-medium transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700 shadow-sm transition">Perbarui Produk</button>
            </div>
        </form>
    </div>
</body>
</html>