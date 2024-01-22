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
        Schema::create('tea_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tea_id');
            $table->string('name');
            $table->foreign('tea_id')->references('id')->on('tea')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tea_images');
    }
};
