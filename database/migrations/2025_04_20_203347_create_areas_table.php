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
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Add area_id to projects table
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('area_id')->nullable()->after('user_id')->constrained('areas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First remove the foreign key from projects
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['area_id']);
            $table->dropColumn('area_id');
        });

        // Then drop the areas table
        Schema::dropIfExists('areas');
    }
};
