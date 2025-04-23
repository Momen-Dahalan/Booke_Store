<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('publisher_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('isbn')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('publisher_year')->nullable();
            $table->unsignedInteger('number_of_pages');
            $table->unsignedInteger('number_of_copies');
            $table->decimal('price' , 8 , 2);
            $table->string('cover_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
