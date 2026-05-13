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
        Schema::create('alumni_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('alumni_name');
            $table->string('graduation_year');
            $table->string('student_id');
            // Governance State
            $table->string('status')->default('pending'); // pending, flagged, verified, rejected
            $table->integer('risk_score')->nullable();
            $table->text('ai_reasoning')->nullable();
            $table->string('proof_id')->nullable(); // The Midnight Seal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_verifications');
    }
};
