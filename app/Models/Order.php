<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $primaryKey = 'id_order';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        $order = Order::find($order_id);
        $products = $order->products;
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('quantity');
    }
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id_order');
    }
}
