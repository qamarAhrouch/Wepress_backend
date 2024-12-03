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
        Schema::create('packs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Links the pack to the user
            $table->string('pack_type'); // e.g., Silver, Gold, Platinum
            $table->integer('total_annonces'); // Total number of annonces in the pack
            $table->integer('remaining_annonces'); // Remaining annonces available in the pack
            $table->decimal('price_per_annonce', 8, 2); // Price per annonce within this pack
            $table->decimal('total_price', 8, 2); // Total price of the pack
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packs');
    }
};
