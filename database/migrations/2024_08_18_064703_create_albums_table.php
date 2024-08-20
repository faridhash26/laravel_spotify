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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->date('release_date');	
            $table->string("name");
            $table->string("description");
            $table->unsignedBigInteger('artist_id'); 
            $table->unsignedBigInteger('genre_id'); 
            $table->unsignedBigInteger('poster_image_id')->nullable(); 
            $table->unsignedBigInteger('background_image_id')->nullable(); 

            $table->foreign('artist_id')->references('id')->on('artists') ->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres') ->onDelete('cascade');
            $table->foreign('poster_image_id')->references('id')->on('images') ->onDelete('set null');
            $table->foreign('background_image_id')->references('id')->on('images') ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
