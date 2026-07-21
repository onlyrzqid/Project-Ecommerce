<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Menampilkan Katalog Utama, Pencarian, & Filter Kategori
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::with('category')->latest();

        // Filter berdasarkan kategori yang dipilih
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter berdasarkan kata kunci pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(8);

        return view('welcome', compact('products', 'categories'));
    }

    // Menampilkan Halaman Detail Produk
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}