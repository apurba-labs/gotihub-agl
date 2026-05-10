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
        Schema::create('shielded_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('proof_id')->unique();
            $table->string('merkle_root');
            $table->string('transaction_id_hash'); 
            $table->string('network')->default('Midnight Testnet');
            $table->string('status')->default('shielded');
            $table->softDeletes(); // Matches your CLI choice earlier
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shielded_transactions');
    }
};
