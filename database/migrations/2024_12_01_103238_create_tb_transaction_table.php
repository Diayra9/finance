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
    public function up(): void
    {
        Schema::table('tb_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->decimal('nominal', 10, 0)->nullable();
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('wallet_id')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transaction');
    }
};
