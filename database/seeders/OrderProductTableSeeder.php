<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderProduct;

class OrderProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CREATION ORDER PRODUCT
        $orderProduct = new OrderProduct();
        $orderProduct->id = 1;
        $orderProduct->order_id = 1; // 120523001 - ADMIN
        $orderProduct->product_id = 1;
        $orderProduct->quantity = 1;
        $orderProduct->save();

        // CREATION ORDER PRODUCT
        $orderProduct = new OrderProduct();
        $orderProduct->id = 2;
        $orderProduct->order_id = 2; // 120523002 - ADMIN
        $orderProduct->product_id = 10;
        $orderProduct->quantity = 1;
        $orderProduct->save();

        // CREATION ORDER PRODUCT
        $orderProduct = new OrderProduct();
        $orderProduct->id = 3;
        $orderProduct->order_id = 3; // 120523003 - Stéphanie
        $orderProduct->product_id = 5;
        $orderProduct->quantity = 2;
        $orderProduct->save();

        // CREATION ORDER PRODUCT
        $orderProduct = new OrderProduct();
        $orderProduct->id = 4;
        $orderProduct->order_id = 4; // 120523004 - Rogeiro
        $orderProduct->product_id = 17;
        $orderProduct->quantity = 1;
        $orderProduct->save();

        // CREATION ORDER PRODUCT
        $orderProduct = new OrderProduct();
        $orderProduct->id = 5;
        $orderProduct->order_id = 5; // 13523001 - Rogeiro
        $orderProduct->product_id = 20;
        $orderProduct->quantity = 2;
        $orderProduct->save();
    }
}
