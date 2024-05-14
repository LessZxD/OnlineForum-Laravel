<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('konten');
            $table->text('image');
            $table->integer('quantity');
            $table->decimal('total', 10, 2)->nullable();
            
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('premium_id');
            $table->foreign('premium_id')->references('id')->on('premium');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
};
