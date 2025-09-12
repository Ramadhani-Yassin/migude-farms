<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAvailableVolumeToMilkBatchesTable extends Migration
{
    public function up(): void
    {
        Schema::table('milk_batches', function (Blueprint $table) {
            if (!Schema::hasColumn('milk_batches', 'available_volume')) {
                $table->decimal('available_volume', 20, 8)->default(0)->after('volume_l');
            }
        });

        // Backfill available_volume = current volume_l
        DB::table('milk_batches')->update([
            'available_volume' => DB::raw('volume_l')
        ]);
    }

    public function down(): void
    {
        Schema::table('milk_batches', function (Blueprint $table) {
            if (Schema::hasColumn('milk_batches', 'available_volume')) {
                $table->dropColumn('available_volume');
            }
        });
    }
} 