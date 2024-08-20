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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger('artist_id'); 
            $table->unsignedBigInteger('genre_id'); 
            $table->date('release_date');	
            $table->time('duration');	
            $table->foreign('artist_id')->references('id')->on('artists') ->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres') ->onDelete('cascade');

            $table->unsignedBigInteger('album_id')->nullable();
            $table->foreign('album_id')->references('id')->on('albums') ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
