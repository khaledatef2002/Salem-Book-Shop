<?php

use App\ApproavedStatusType;
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
        Schema::table('blogs', function (Blueprint $table) {
            $table->enum('approaved', [ApproavedStatusType::pending->value, ApproavedStatusType::approaved->value, ApproavedStatusType::canceled->value])->default(ApproavedStatusType::pending->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('approaved');
        });
    }
};
