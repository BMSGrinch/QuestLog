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
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruiter_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('company');
            $table->text('description');
            $table->string('location');
            $table->enum('contract_type',['CDI','CDD','Stage','Freelance']);
            $table->string('salary',)->nullable();
            $table->integer('experience_min',)->default(0);
            $table->integer('experience_max',)->nullable();
            $table->text('skills_required',);
            $table->date('application_deadline',)->nullable();
            $table->enum('remote_policy',['onsite','remote','hybrid']);
            $table->enum('status',['draft','open','closed'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
