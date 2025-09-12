<?php

namespace App\Http\Controllers\Milk;

use App\Http\Controllers\Controller;
use App\Models\MilkBatch;
use Illuminate\Http\Request;

class MilkBatchController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int)($request->get('per_page', 100));
        $query = MilkBatch::query();

        if ($request->filled('batch_no')) {
            $query->where('batch_no', 'like', '%' . $request->get('batch_no') . '%');
        }

        return $query->orderBy('batch_no')->paginate($perPage);
    }

    public function show(MilkBatch $milkBatch)
    {
        return $milkBatch;
    }
} 