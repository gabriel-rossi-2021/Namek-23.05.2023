<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // CREATION DE LA TABLE Order
        Schema::create('order', function (Blueprint $table) {
            $table->id('id_order')->nullable(false);
            $table->bigInteger('order_number')->nullable(false);
            $table->string('status', 50 )->nullable(false);
            $table->dateTime('date_purchase')->nullable(false);

            // CLE ETRANGERE
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id_users')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id_product')->on('products')->onDelete('cascade');

            // Date / Heure
            $table->timestamps();

            // ACTIVER LES CONTRAINTES DE LA CLE ETRANGERE
            Schema::enableForeignKeyConstraints();
        });
    }

    public function down()
    {
        // DESACTIVER LES CONTRAINTES
        Schema::disableForeignKeyConstraints();

        $table->dropForeign(['user_id']);
        $table->dropForeign(['product_id']);
    }
};
