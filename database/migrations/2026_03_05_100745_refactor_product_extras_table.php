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
        // Drop the pivot table first
        Schema::dropIfExists('product_product_extra');

        Schema::table('product_extras', function (Blueprint $table) {
            // Drop foreign key and column if they exist
            if (Schema::hasColumn('product_extras', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
            if (Schema::hasColumn('product_extras', 'type')) {
                $table->dropColumn('type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_extras', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnDelete();
            $table->enum('type', ['size', 'extra'])->default('size');
        });

        // Recreate pivot (simplified)
        Schema::create('product_product_extra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('product_extra_id')->constrained('product_extras')->cascadeOnDelete();
            $table->timestamps();
        });
    }
};
