<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total_harga', 'status', 'nomor_resi'];

public function user() {
    return $this->belongsTo(User::class);
}

public function products() {
    return $this->belongsToMany(Product::class, 'order_items')->withPivot('kuantitas', 'harga_saat_beli');
}
}
