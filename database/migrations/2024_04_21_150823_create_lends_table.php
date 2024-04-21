<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('lends', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_user_id')->nullable();
            $table->bigInteger('owner_user_id')->nullable();
            $table->bigInteger('book_id')->nullable();
            $table->date('date_out');
            $table->date('date_in')->nullable();
            $table->enum('status', ['PRESTADO','REVISION', 'EN SALA'])->nullable()->default('EN SALA');
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('customer_user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('owner_user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lends');
    }
};
