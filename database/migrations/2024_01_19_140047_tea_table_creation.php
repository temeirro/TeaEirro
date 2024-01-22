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
        Schema::create("tea", function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('type_id'); // Foreign key
            $table->unsignedBigInteger('origin_id'); // Foreign key
            $table->string("name");
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);

            $table->foreign('type_id')->references('id')->on('tea_types');
            $table->foreign('origin_id')->references('id')->on('tea_origins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tea');
    }
};
