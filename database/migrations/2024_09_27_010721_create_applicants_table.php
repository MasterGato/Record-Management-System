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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('Firstname');
            $table->string('Lastname');
            $table->string('Middleinitial')->nullable();
            $table->string('Gender');
            $table->string('Contact');
            $table->string('Email')->unique();
            $table->date('Dateofbirth');
            $table->string('Citizenship');
            $table->string('Region');
            $table->string('Province');
            $table->string('City');
            $table->string('Brgy');
            $table->string('Zipcode');
            $table->string('Password');
            $table->foreignId('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
