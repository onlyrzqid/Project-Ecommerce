<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Penjualan (HANYA menghitung transaksi yang berstatus 'Selesai')
        $totalPenjualan = Order::where('status', 'Selesai')->sum('total_harga');

        // 2. Jumlah Order (Menghitung semua transaksi aktif)
        $jumlahOrder = Order::where('status', '!=', 'dibatalkan')->count();

        // 3. Produk Terlaris (HANYA menghitung dari transaksi yang 'Selesai')
        $produkTerlaris = Product::select('products.nama', DB::raw('SUM(order_items.qty) as total_terjual'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '=', 'Selesai') // <-- Ubah bagian ini ke 'Selesai'
            ->groupBy('products.id', 'products.nama')
            ->orderBy('total_terjual', 'DESC')
            ->first();

        return view('admin.dashboard', compact('totalPenjualan', 'jumlahOrder', 'produkTerlaris'));
    }
}