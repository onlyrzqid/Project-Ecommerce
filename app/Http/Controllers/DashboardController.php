<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung total rupiah seluruh transaksi (kecuali yang dibatalkan)
        $totalPenjualan = Order::where('status', '!=', 'dibatalkan')->sum('total_harga');

        // 2. Menghitung total banyaknya pesanan/checkout yang masuk
        $jumlahOrder = Order::count();

        // 3. Menentukan produk mana yang paling banyak dibeli (menggunakan kolom qty)
        $produkTerlaris = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.nama', DB::raw('SUM(order_items.qty) as total_terjual'))
            ->groupBy('products.id', 'products.nama')
            ->orderByDesc('total_terjual')
            ->first();

        return view('admin.dashboard', compact('totalPenjualan', 'jumlahOrder', 'produkTerlaris'));
    }
}