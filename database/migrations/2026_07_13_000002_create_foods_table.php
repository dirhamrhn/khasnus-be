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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained('provinces')->cascadeOnDelete();
            $table->string('name', 150);
            $table->text('description');
            $table->text('description_en')->nullable();
            $table->text('ingredients');
            $table->text('ingredients_en')->nullable();
            $table->text('recipe');
            $table->text('recipe_en')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('youtube_link', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
