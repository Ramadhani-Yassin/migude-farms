<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MilkProduct extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	protected $casts = [
		'base_quantity_l' => 'decimal:3',
		'selling_price' => 'decimal:2',
		'packaging_cost' => 'decimal:2',
		'net_price' => 'decimal:2',
	];

	public function productions(): HasMany
	{
		return $this->hasMany(MilkProduction::class);
	}
} 