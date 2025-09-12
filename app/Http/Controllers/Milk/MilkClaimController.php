<?php

namespace App\Http\Controllers\Milk;

use App\Http\Controllers\Controller;
use App\Models\MilkClaim;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MilkClaimController extends Controller
{
	public function index(Request $request)
	{
		$query = MilkClaim::query()->latest('claim_date');
		if ($request->filled('person')) {
			$query->where('person', 'like', '%' . $request->string('person') . '%');
		}
		if ($request->filled('batch_no')) {
			$query->where('batch_no', $request->string('batch_no'));
		}
		return response()->json($query->paginate(50));
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'claim_date' => ['required', 'date'],
			'person' => ['required', 'string', 'max:255'],
			'cost_centre' => ['required', 'string', 'max:255'],
			'item' => ['required', 'string', 'max:255'],
			'price' => ['required', 'numeric', 'min:0'],
			'units' => ['required', 'numeric', 'min:0'],
			'amount' => ['nullable', 'numeric', 'min:0'],
			'paid_amount' => ['nullable', 'numeric', 'min:0'],
			'balance' => ['nullable', 'numeric'],
			'batch_no' => ['nullable', 'string', 'max:255'],
			'notice' => ['nullable', 'string'],
		]);
		if (!isset($data['amount'])) {
			$data['amount'] = (float)$data['price'] * (float)$data['units'];
		}
		if (!isset($data['balance'])) {
			$data['balance'] = (float)$data['amount'] - (float)($data['paid_amount'] ?? 0);
		}
		$claim = MilkClaim::create($data);
		return response()->json($claim, Response::HTTP_CREATED);
	}

	public function update(Request $request, MilkClaim $milkClaim)
	{
		$data = $request->validate([
			'person' => ['sometimes', 'string', 'max:255'],
			'cost_centre' => ['sometimes', 'string', 'max:255'],
			'item' => ['sometimes', 'string', 'max:255'],
			'price' => ['sometimes', 'numeric', 'min:0'],
			'units' => ['sometimes', 'numeric', 'min:0'],
			'amount' => ['nullable', 'numeric', 'min:0'],
			'paid_amount' => ['nullable', 'numeric', 'min:0'],
			'balance' => ['nullable', 'numeric'],
			'batch_no' => ['nullable', 'string', 'max:255'],
			'notice' => ['nullable', 'string'],
		]);
		if (!isset($data['amount']) && (isset($data['price']) || isset($data['units']))) {
			$price = $data['price'] ?? $milkClaim->price;
			$units = $data['units'] ?? $milkClaim->units;
			$data['amount'] = (float)$price * (float)$units;
		}
		if (!isset($data['balance']) && (isset($data['amount']) || isset($data['paid_amount']))) {
			$amount = $data['amount'] ?? $milkClaim->amount;
			$paid = $data['paid_amount'] ?? $milkClaim->paid_amount;
			$data['balance'] = (float)$amount - (float)$paid;
		}
		$milkClaim->update($data);
		return response()->json($milkClaim);
	}

	public function destroy(MilkClaim $milkClaim)
	{
		$milkClaim->delete();
		return response()->json(null, Response::HTTP_NO_CONTENT);
	}
} 