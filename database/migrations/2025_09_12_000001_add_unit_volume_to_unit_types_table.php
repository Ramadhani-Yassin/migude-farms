<?php

use App\Enums\UnitType\UnitTypeFieldsEnum;
use App\Models\UnitType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table((new UnitType())->getTable(), function (Blueprint $table) {
            if (!Schema::hasColumn((new UnitType())->getTable(), UnitTypeFieldsEnum::UNIT_VOLUME->value)) {
                $table->decimal(UnitTypeFieldsEnum::UNIT_VOLUME->value, 20, 8)->default(1)->after(UnitTypeFieldsEnum::SYMBOL->value);
            }
        });
    }

    public function down(): void
    {
        Schema::table((new UnitType())->getTable(), function (Blueprint $table) {
            if (Schema::hasColumn((new UnitType())->getTable(), UnitTypeFieldsEnum::UNIT_VOLUME->value)) {
                $table->dropColumn(UnitTypeFieldsEnum::UNIT_VOLUME->value);
            }
        });
    }
}; 