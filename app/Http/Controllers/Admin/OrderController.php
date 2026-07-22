<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Tampilkan Semua Pesanan Masuk
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // Tampilkan Detail Pesanan
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    // Ubah Status Pesanan (Pending, Diproses, Selesai, Dibatalkan)
    // Ubah Status Pesanan (Pending, Diproses, Selesai, Dibatalkan)
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,dibatalkan',
        ]);

        // Kunci keamanan: Tolak perubahan jika status saat ini sudah selesai/dibatalkan
        if (in_array(strtolower($order->status), ['selesai', 'dibatalkan'])) {
            return redirect()->back()->with('error', 'Gagal! Status pesanan yang sudah selesai atau dibatalkan tidak dapat diubah lagi.');
        }

        // Cek jika status diubah menjadi "dibatalkan"
        if (strtolower($request->status) === 'dibatalkan') {
            // Menggunakan relasi 'items' sesuai dengan yang ada di model Order.php
            $order->load('items.product');

            foreach ($order->items as $item) {
                if ($item->product) {
                    // Catatan: Jika di tabel order_items kolom kuantitas bernama 'jumlah' atau 'qty', 
                    // sesuaikan $item->quantity di bawah (misal: $item->jumlah / $item->qty)
                    $item->product->increment('stok', $item->qty);
                }
            }
        }

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}