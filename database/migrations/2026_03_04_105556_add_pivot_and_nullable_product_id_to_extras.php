<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Make product_id nullable so extras can exist standalone
        Schema::table('product_extras', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->change();
        });

        // Create many-to-many pivot table
        Schema::create('product_product_extra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('product_extra_id')->constrained('product_extras')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_product_extra');

        Schema::table('product_extras', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable(false)->change();
        });
    }
};
