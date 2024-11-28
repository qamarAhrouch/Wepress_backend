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
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->enum('type', ['constitution', 'cessation', 'modification']); 
            $table->string('title'); 
            $table->text('content'); 
            $table->string('ice'); 
            $table->string('status')->default('pending'); 
            $table->string('ref_web')->unique(); 
            $table->date('date_parution')->nullable(); 
            $table->string('canal_de_publication')->default('Papier + Digital');
            $table->string('ville')->nullable();
            $table->boolean('publication_web')->default(false);
            $table->string('file_attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
