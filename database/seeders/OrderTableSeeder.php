<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderTableSeeder extends Seeder
{
    public function run()
    {
        // CREATION ORDER
        $order = new Order();
        $order->order_number = 120523001;
        $order->status = 'En attente';
        $order->date_purchase = '2023-05-12 09:11:18';
        $order->user_id = 1; // ADMIN
        $order->product_id = null;
        $order->save();

        // CREATION ORDER
        $order = new Order();
        $order->order_number = 120523002;
        $order->status = 'En cours';
        $order->date_purchase = '2023-05-12 10:11:18';
        $order->user_id = 1; // ADMIN
        $order->product_id = null;
        $order->save();

        // CREATION ORDER
        $order = new Order();
        $order->order_number = 120523003;
        $order->status = 'En cours';
        $order->date_purchase = '2023-05-12 10:12:18';
        $order->user_id = 2; // Stéphanie
        $order->product_id = null;
        $order->save();

        // CREATION ORDER
        $order = new Order();
        $order->order_number = 120523004;
        $order->status = 'Terminé';
        $order->date_purchase = '2023-05-12 12:12:18';
        $order->user_id = 3; // Rogeiro
        $order->product_id = null;
        $order->save();

        // CREATION ORDER
        $order = new Order();
        $order->order_number = 130523001;
        $order->status = 'En cours';
        $order->date_purchase = '2023-05-13 11:12:18';
        $order->user_id = 3; // Rogeiro
        $order->product_id = null;
        $order->save();
    }
}
