<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Discount;

class DiscountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discount= new Discount();
        $discount->name_discount = "M151";
        $discount->percentage = 25;
        $discount->status = "actif";
        $discount->save();

        $discount= new Discount();
        $discount->name_discount = "AVRIL";
        $discount->percentage = 20;
        $discount->status = "passif";
        $discount->save();
    }
}
