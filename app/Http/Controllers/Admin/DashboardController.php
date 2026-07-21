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
        // 1. Menghitung total uang masuk dari pesanan yang sukses (Diproses / Selesai)
        $totalPenjualan = Order::whereIn('status', ['Diproses', 'Selesai'])->sum('total_harga');

        // 2. Menghitung total seluruh pesanan yang masuk
        $jumlahOrder = Order::count();

        // 3. Mencari produk terlaris berdasarkan kuantitas terbanyak di tabel pivot order_items
        $produkTerlaris = Product::select('products.nama', DB::raw('SUM(order_items.kuantitas) as total_terjual'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id', 'products.nama')
            ->orderBy('total_terjual', 'DESC')
            ->first();

        // Mengirimkan data metrik ke halaman view dashboard admin
        return view('admin.dashboard', compact('totalPenjualan', 'jumlahOrder', 'produkTerlaris'));
    }
}