<?php

namespace App\Http\Controllers\Milk;

use App\Http\Controllers\Controller;
use App\Models\MilkProduction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MilkProductionController extends Controller
{
	public function index(Request $request)
	{
		$query = MilkProduction::query()->latest('id');
		if ($request->filled('milk_batch_id')) {
			$query->where('milk_batch_id', $request->integer('milk_batch_id'));
		}
		return response()->json($query->with(['product'])->paginate(50));
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'milk_batch_id' => ['required', 'exists:milk_batches,id'],
			'milk_product_id' => ['required', 'exists:milk_products,id'],
			'produced_units' => ['required', 'numeric', 'min:0'],
			'milk_consumed_l' => ['required', 'numeric', 'min:0'],
		]);
		$production = MilkProduction::create($data);
		return response()->json($production->load('product'), Response::HTTP_CREATED);
	}

	public function update(Request $request, MilkProduction $milkProduction)
	{
		$data = $request->validate([
			'produced_units' => ['sometimes', 'numeric', 'min:0'],
			'milk_consumed_l' => ['sometimes', 'numeric', 'min:0'],
		]);
		$milkProduction->update($data);
		return response()->json($milkProduction->load('product'));
	}

	public function destroy(MilkProduction $milkProduction)
	{
		$milkProduction->delete();
		return response()->json(null, Response::HTTP_NO_CONTENT);
	}
} 