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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('tag', 20)->unique();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('series', 100)->nullable();
            $table->string('status')->default('active');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('location_id')->nullable()->constrained('locations');
            $table->foreignId('contact_id')->nullable()->constrained('contacts');
            $table->text('decommission_reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
