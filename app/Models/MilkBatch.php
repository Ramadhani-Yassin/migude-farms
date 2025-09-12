<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MilkBatch extends Model
{
    use HasFactory;

    protected $table = 'milk_batches';

    protected $fillable = [
        'batch_date',
        'batch_no',
        'person',
        'volume_l',
        'available_volume',
        'milk_unit_price',
        'milk_purchase_cost',
        'labour_cost',
        'other_expenses_total',
        'total_sales_expected',
        'profit_margin',
        'notes',
    ];

    protected $casts = [
        'batch_date' => 'date:Y-m-d',
    ];

    public function labours(): HasMany
    {
        return $this->hasMany(MilkBatchLabour::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(MilkBatchExpense::class);
    }

    public function productions(): HasMany
    {
        return $this->hasMany(MilkProduction::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(MilkStockMovement::class);
    }
} 