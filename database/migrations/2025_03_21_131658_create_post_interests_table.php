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
        Schema::create('post_interests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('post_id'); // تعديل ليكون متوافقًا مع posts.id
            $table->unsignedBigInteger('interest_id'); // تعديل ليكون متوافقًا مع interests.id
            $table->timestamps();
        
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('interest_id')->references('id')->on('interests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_interests');
    }
};
