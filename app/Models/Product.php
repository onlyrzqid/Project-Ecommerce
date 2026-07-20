<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'nama', 'harga', 'stok', 'foto', 'deskripsi'];

public function category() {
    return $this->belongsTo(Category::class);
}

public function orders() {
    return $this->belongsToMany(Order::class, 'order_items')->withPivot('kuantitas', 'harga_saat_beli');
}
}
