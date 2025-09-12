<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMilkBatchIdToProductsTable extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'milk_batch_id')) {
                $table->foreignId('milk_batch_id')
                    ->nullable()
                    ->after('supplier_id')
                    ->constrained('milk_batches')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'milk_batch_id')) {
                $table->dropForeign(['milk_batch_id']);
                $table->dropColumn('milk_batch_id');
            }
        });
    }
} 