<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MilkBatchExpense extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	protected $casts = [
		'expense_date' => 'date',
	];

	public function batch(): BelongsTo
	{
		return $this->belongsTo(MilkBatch::class, 'milk_batch_id');
	}
} 