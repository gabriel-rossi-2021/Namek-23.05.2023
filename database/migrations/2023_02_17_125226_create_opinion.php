<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // CREATION DE LA TABLE Opinion
        Schema::create('opinion', function (Blueprint $table) {
            $table->id('id_opinion')->nullable(false);
            $table->smallInteger('notation')->nullable(false);
            $table->string('comment', 255 )->nullable(false);

            // Clé étrangère pour lier le commentaire à l'utilisateur
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id_users')->on('users')->onDelete('cascade');

            // Clé étrangère pour lier le commentaire au produit
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id_product')->on('products')->onDelete('cascade');


            // Date / Heure
            $table->timestamps();
        });
    }

    public function down()
    {
        //
    }
};
