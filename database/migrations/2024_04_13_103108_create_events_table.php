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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image_cover')->default('https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png'); // URL to Cloudinary
            $table->string('image_background')->default('https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png');; // URL to Cloudinary
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
