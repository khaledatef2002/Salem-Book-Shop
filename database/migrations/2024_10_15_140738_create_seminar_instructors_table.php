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
        Schema::create('seminar_instructors', function (Blueprint $table) {
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('seminar_id');
            
            // Foreign key constraints
            $table->foreign('instructor_id')->on('people')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('seminar_id')->on('seminars')->references('id')->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['instructor_id', 'seminar_id']); // composite primary key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar_instructors');
    }
};
