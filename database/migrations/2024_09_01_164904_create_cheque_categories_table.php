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
        Schema::create('cheque_categories', function (Blueprint $table) {
            $table->id();
            $table->string('manual_cheque_id')->nullable();
            $table->string('laser_cheque_id')->nullable();
            $table->string('personal_cheque_id')->nullable();
            $table->string('chequeName');
            $table->string('price');
            $table->string('img');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheque_categories');
    }
};
