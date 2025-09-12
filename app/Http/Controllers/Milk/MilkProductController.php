<?php

namespace App\Http\Controllers\Milk;

use App\Http\Controllers\Controller;
use App\Models\MilkProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MilkProductController extends Controller
{
	public function index(Request $request)
	{
		$query = MilkProduct::query()->orderBy('unit_label');
		if ($request->boolean('all')) {
			return response()->json($query->get());
		}
		return response()->json($query->paginate(50));
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'name' => ['required','string','max:255'],
			'base_quantity_l' => ['required','numeric','min:0'],
			'unit_label' => ['required','string','max:255'],
			'selling_price' => ['required','numeric','min:0'],
			'packaging_cost' => ['nullable','numeric','min:0'],
			'net_price' => ['nullable','numeric','min:0'],
			'active' => ['boolean'],
		]);
		if (!isset($data['net_price'])) {
			$data['net_price'] = (float)($data['selling_price'] ?? 0) - (float)($data['packaging_cost'] ?? 0);
		}
		$product = MilkProduct::create($data);
		return response()->json($product, Response::HTTP_CREATED);
	}

	public function update(Request $request, MilkProduct $milkProduct)
	{
		$data = $request->validate([
			'name' => ['sometimes','string','max:255'],
			'base_quantity_l' => ['sometimes','numeric','min:0'],
			'unit_label' => ['sometimes','string','max:255'],
			'selling_price' => ['sometimes','numeric','min:0'],
			'packaging_cost' => ['nullable','numeric','min:0'],
			'net_price' => ['nullable','numeric','min:0'],
			'active' => ['boolean'],
		]);
		if (!isset($data['net_price']) && (isset($data['selling_price']) || isset($data['packaging_cost']))) {
			$sp = $data['selling_price'] ?? $milkProduct->selling_price;
			$pc = $data['packaging_cost'] ?? $milkProduct->packaging_cost;
			$data['net_price'] = (float)$sp - (float)$pc;
		}
		$milkProduct->update($data);
		return response()->json($milkProduct);
	}

	public function destroy(MilkProduct $milkProduct)
	{
		$milkProduct->delete();
		return response()->json(null, Response::HTTP_NO_CONTENT);
	}
} 