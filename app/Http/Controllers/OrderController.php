<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1. Tampilkan Halaman Form Checkout
    public function checkout()
    {
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();

        // Jika keranjang kosong, kembalikan ke beranda
        if ($carts->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang belanja Anda kosong.');
        }

        return view('orders.checkout', compact('carts'));
    }

    // 2. Simpan Pesanan, Potong Stok, & Kosongkan Keranjang
    public function store(Request $request)
    {
        $request->validate([
            'nama_penerima'     => 'required|string|max:255',
            'no_hp'             => 'required|string|max:20',
            'alamat_pengiriman' => 'required|string',
            'metode_pembayaran' => 'required|string',
        ]);

        $carts = Cart::with('product')->where('user_id', auth()->id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('home');
        }

        // Gunakan DB Transaction agar jika terjadi gagal sistem, data tidak setengah tersimpan
        DB::transaction(function () use ($request, $carts) {
            $totalHarga = $carts->sum(fn($cart) => $cart->product->harga * $cart->qty);

            // A. Simpan Data Utama Order
            $order = Order::create([
                'user_id'           => auth()->id(),
                'kode_transaksi'    => 'TRX-' . strtoupper(Str::random(8)),
                'total_harga'       => $totalHarga,
                'nama_penerima'     => $request->nama_penerima,
                'no_hp'             => $request->no_hp,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status'            => 'pending',
            ]);

            // B. Simpan Detail Item Order & Kurangi Stok Produk
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cart->product_id,
                    'qty'        => $cart->qty,
                    'harga'      => $cart->product->harga,
                ]);

                // Pengurangan Stok Produk Otomatis
                Product::where('id', $cart->product_id)->decrement('stok', $cart->qty);
            }

            // C. Kosongkan Keranjang Belanja Pengguna
            Cart::where('user_id', auth()->id())->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat! Terima kasih telah berbelanja.');
    }

    // 3. Tampilkan Riwayat Pesanan Pengguna
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(5);

        return view('orders.index', compact('orders'));
    }
}