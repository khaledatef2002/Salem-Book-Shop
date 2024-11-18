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
        Schema::table('books', function (Blueprint $table) {
            // Drop the existing foreign key
            $table->dropForeign(['author_id']);

            // Add the new foreign key with onDelete cascade
            $table->foreign('author_id')
                  ->references('id')
                  ->on('people')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->foreign('author_id')->on('people')->references('id')->onDelete('set null')->onUpdate('cascade');
        });
        
    }
};
