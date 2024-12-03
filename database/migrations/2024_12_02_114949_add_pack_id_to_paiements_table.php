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
        Schema::table('paiements', function (Blueprint $table) {
            $table->unsignedBigInteger('pack_id')->nullable()->after('annonce_id'); // Nullable for standalone payments
            $table->foreign('pack_id')->references('id')->on('packs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropForeign(['pack_id']); // Drop the foreign key constraint
            $table->dropColumn('pack_id');   // Remove the pack_id column
        });
    }
};
