<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posiflora_orders', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->string('docNo');
            $table->bigInteger('amount');
            $table->string('payment')->nullable(false);
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posiflora_orders');
    }
};
