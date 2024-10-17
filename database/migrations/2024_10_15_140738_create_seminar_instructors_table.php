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
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
            $table->foreign('seminar_id')->references('id')->on('seminars')->onDelete('cascade');

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
