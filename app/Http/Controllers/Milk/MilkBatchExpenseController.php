<?php

namespace App\Http\Controllers\Milk;

use App\Http\Controllers\Controller;
use App\Models\MilkBatchExpense;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MilkBatchExpenseController extends Controller
{
	public function index(Request $request)
	{
		$query = MilkBatchExpense::query()->latest('expense_date');
		if ($request->filled('milk_batch_id')) {
			$query->where('milk_batch_id', $request->integer('milk_batch_id'));
		}
		return response()->json($query->paginate(50));
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'milk_batch_id' => ['required', 'exists:milk_batches,id'],
			'cost_centre' => ['required', 'string', 'max:255'],
			'item' => ['required', 'string', 'max:255'],
			'unit_price' => ['required', 'numeric', 'min:0'],
			'units' => ['required', 'numeric', 'min:0'],
			'total' => ['nullable', 'numeric', 'min:0'],
			'expense_date' => ['nullable', 'date'],
		]);
		if (!isset($data['total'])) {
			$data['total'] = (float)$data['unit_price'] * (float)$data['units'];
		}
		$expense = MilkBatchExpense::create($data);
		return response()->json($expense, Response::HTTP_CREATED);
	}

	public function update(Request $request, MilkBatchExpense $milkBatchExpense)
	{
		$data = $request->validate([
			'cost_centre' => ['sometimes', 'string', 'max:255'],
			'item' => ['sometimes', 'string', 'max:255'],
			'unit_price' => ['sometimes', 'numeric', 'min:0'],
			'units' => ['sometimes', 'numeric', 'min:0'],
			'total' => ['nullable', 'numeric', 'min:0'],
			'expense_date' => ['nullable', 'date'],
		]);
		if (!isset($data['total']) && (isset($data['unit_price']) || isset($data['units']))) {
			$unit = $data['unit_price'] ?? $milkBatchExpense->unit_price;
			$units = $data['units'] ?? $milkBatchExpense->units;
			$data['total'] = (float)$unit * (float)$units;
		}
		$milkBatchExpense->update($data);
		return response()->json($milkBatchExpense);
	}

	public function destroy(MilkBatchExpense $milkBatchExpense)
	{
		$milkBatchExpense->delete();
		return response()->json(null, Response::HTTP_NO_CONTENT);
	}
} 