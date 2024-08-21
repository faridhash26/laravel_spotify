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
        Schema::table('songs', function (Blueprint $table) {
            $table->unsignedBigInteger('poster_image_id')->nullable(); 
            $table->unsignedBigInteger('background_image_id')->nullable();
            $table->string('url');
            $table->foreign('poster_image_id')->references('id')->on('images') ->onDelete('set null');
            $table->foreign('background_image_id')->references('id')->on('images') ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('poster_image_id');
            $table->dropColumn('background_image_id');
        });
    }
};
