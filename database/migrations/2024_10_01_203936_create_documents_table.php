<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');// Foreign key to applications // Foreign key to applicants
            $table->string('valid_id')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('medical_certificate')->nullable();
            $table->string('nbi_clearance')->nullable();
            $table->string('marriage_certificate')->nullable(); // Nullable for unmarried applicants
            $table->string('passport')->nullable();
            $table->text('description')->nullable(); // Optional description field
            $table->string('status')->default('pending'); // Status starts as 'pending'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
