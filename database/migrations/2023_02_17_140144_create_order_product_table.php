<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        // CREATION DE LA TABLE DE LIAISON order_product
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            // CLES ETRANGERES
            $table->foreign('order_id')->references('id_order')->on('order')->onDelete('cascade');
            $table->foreign('product_id')->references('id_product')->on('products')->onDelete('cascade');

            // ACTIVER LES CONTRAINTES DE LA CLE ETRANGERE
            Schema::enableForeignKeyConstraints();
        });

    }


    public function down()
    {
        // DESACTIVER LES CONTRAINTES
        Schema::disableForeignKeyConstraints();

        // SUPPRESSION DE LA TABLE DE LIAISON order_product
        Schema::dropIfExists('order_product');
    }
};
