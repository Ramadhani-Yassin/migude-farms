<?php

namespace App\Http\Controllers\Milk;

use App\Http\Controllers\Controller;
use App\Models\MilkBatchLabour;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MilkBatchLabourController extends Controller
{
	public function index(Request $request)
	{
		$query = MilkBatchLabour::query()->latest('labour_date');
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
			'person' => ['nullable', 'string', 'max:255'],
			'job_title' => ['nullable', 'string', 'max:255'],
			'daily_wage' => ['required', 'numeric', 'min:0'],
			'days' => ['required', 'numeric', 'min:0'],
			'total' => ['nullable', 'numeric', 'min:0'],
			'labour_date' => ['nullable', 'date'],
		]);
		if (!isset($data['total'])) {
			$data['total'] = (float)$data['daily_wage'] * (float)$data['days'];
		}
		$labour = MilkBatchLabour::create($data);
		return response()->json($labour, Response::HTTP_CREATED);
	}

	public function update(Request $request, MilkBatchLabour $milkBatchLabour)
	{
		$data = $request->validate([
			'cost_centre' => ['sometimes', 'string', 'max:255'],
			'person' => ['nullable', 'string', 'max:255'],
			'job_title' => ['nullable', 'string', 'max:255'],
			'daily_wage' => ['sometimes', 'numeric', 'min:0'],
			'days' => ['sometimes', 'numeric', 'min:0'],
			'total' => ['nullable', 'numeric', 'min:0'],
			'labour_date' => ['nullable', 'date'],
		]);
		if (!isset($data['total']) && (isset($data['daily_wage']) || isset($data['days']))) {
			$wage = $data['daily_wage'] ?? $milkBatchLabour->daily_wage;
			$days = $data['days'] ?? $milkBatchLabour->days;
			$data['total'] = (float)$wage * (float)$days;
		}
		$milkBatchLabour->update($data);
		return response()->json($milkBatchLabour);
	}

	public function destroy(MilkBatchLabour $milkBatchLabour)
	{
		$milkBatchLabour->delete();
		return response()->json(null, Response::HTTP_NO_CONTENT);
	}
} 