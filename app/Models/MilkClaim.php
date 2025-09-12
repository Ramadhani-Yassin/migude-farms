<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkClaim extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	protected $casts = [
		'claim_date' => 'date',
		'price' => 'decimal:2',
		'units' => 'decimal:3',
		'amount' => 'decimal:2',
		'paid_amount' => 'decimal:2',
		'balance' => 'decimal:2',
	];
} 