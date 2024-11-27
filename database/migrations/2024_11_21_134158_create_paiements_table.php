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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('annonce_id')->constrained()->onDelete('cascade'); 
            $table->decimal('amount', 10, 2); 
            $table->decimal('tax', 10, 2)->nullable(); 
            $table->decimal('total', 10, 2); 
            $table->string('status')->default('pending'); 
            $table->string('method')->nullable(); 
            $table->string('reference_number')->unique()->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
