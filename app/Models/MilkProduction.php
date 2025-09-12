<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MilkProduction extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	public function batch(): BelongsTo
	{
		return $this->belongsTo(MilkBatch::class, 'milk_batch_id');
	}

	public function product(): BelongsTo
	{
		return $this->belongsTo(MilkProduct::class, 'milk_product_id');
	}
} 