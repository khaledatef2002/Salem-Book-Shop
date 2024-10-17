<?php

use App\MediaType;
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
        Schema::create('seminar_media', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->enum('type', [MediaType::Image->value, MediaType::Youtube->value]);
            $table->unsignedBigInteger('seminar_id');
            $table->foreign('seminar_id')->on('seminars')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar_media');
    }
};
