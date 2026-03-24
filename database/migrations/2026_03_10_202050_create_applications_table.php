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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id',)->constrained('users')->cascadeOnDelete();
            $table->foreignId('job_offer_id')->nullable()->constrained('job_offers')->nullOnDelete();
            $table->string('company_name')->nullable();
            $table->string('position')->nullable();
            $table->string('job_link')->nullable();
            $table->enum('status',['applied','screening','interview','rejected','accepted'])->default('applied');
            $table->date('applied_at');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
