<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. Menampilkan Tabel Semua Produk
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // 2. Menampilkan Form Tambah Produk
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // 3. Menyimpan Produk Baru ke Database
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama'        => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi'   => 'nullable|string',
        ]);

        $data = $request->all();

        // Upload Foto ke folder storage/app/public/products jika ada file diunggah
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk sukses ditambahkan!');
    }

    // 4. Menampilkan Form Edit Data Produk
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // 5. Memperbarui Data Produk di Database
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama'        => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
            'deskripsi'   => 'nullable|string',
        ]);

        $data = $request->all();

        // Jika ada foto baru, hapus foto lama dari penyimpanan lalu unggah yang baru
        if ($request->hasFile('foto')) {
            if ($product->foto) {
                Storage::disk('public')->delete($product->foto);
            }
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk sukses diperbarui!');
    }

    // 6. Menghapus Produk dari Database
    public function destroy(Product $product)
    {
        // Hapus file gambar produk dari direktori storage sebelum record dihapus
        if ($product->foto) {
            Storage::disk('public')->delete($product->foto);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk sukses dihapus!');
    }
}