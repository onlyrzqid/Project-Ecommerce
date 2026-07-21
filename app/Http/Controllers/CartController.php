<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 1. Tampilkan Halaman Keranjang Belanja
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();
        return view('cart.index', compact('carts'));
    }

    // 2. Tambah Produk ke Keranjang
    public function store(Request $request, Product $product)
    {
        // Cek apakah produk sudah ada di keranjang user
        $cart = Cart::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->first();

        if ($cart) {
            // Jika sudah ada, tambahkan qty-nya
            $cart->increment('qty');
        } else {
            // Jika belum ada, buat record baru
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'qty' => 1,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // 3. Update Jumlah (Qty) Produk
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'qty' => 'required|numeric|min:1'
        ]);

        $cart->update(['qty' => $request->qty]);

        return back()->with('success', 'Jumlah produk berhasil diperbarui!');
    }

    // 4. Hapus Produk dari Keranjang
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}