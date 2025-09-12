<?php

namespace App\Http\Controllers\Milk;

use App\Http\Controllers\Controller;
use App\Models\MilkBatch;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\Expense;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MilkWebController extends Controller
{
    public function batches(Request $request): Response|StreamedResponse
    {
        $perPage = (int)($request->get('per_page', 10));

        $query = MilkBatch::query();

        // Filters
        $keyword = $request->get('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('batch_no', 'like', "%{$keyword}%")
                    ->orWhere('person', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('batch_no')) {
            $query->where('batch_no', 'like', '%' . $request->get('batch_no') . '%');
        }

        if ($request->filled('person')) {
            $query->where('person', 'like', '%' . $request->get('person') . '%');
        }

        if ($request->filled('from_date')) {
            $query->whereDate('batch_date', '>=', $request->get('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('batch_date', '<=', $request->get('to_date'));
        }

        // Handle export
        if ($request->filled('export')) {
            $rows = $query->orderByDesc('batch_date')->orderBy('batch_no')->get();
            $filename = 'milk_batches_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            return response()->stream(function () use ($rows) {
                $out = fopen('php://output', 'w');
                fputcsv($out, ['ID', 'Date', 'Batch No', 'Person', 'Volume (L)', 'Unit Price', 'Purchasing Cost', 'Labour Cost', 'Other Expenses', 'Notes']);
                foreach ($rows as $b) {
                    fputcsv($out, [
                        $b->id,
                        $b->batch_date,
                        $b->batch_no,
                        $b->person,
                        $b->volume_l,
                        $b->milk_unit_price,
                        $b->milk_purchase_cost,
                        $b->labour_cost,
                        $b->other_expenses_total,
                        $b->notes,
                    ]);
                }
                fclose($out);
            }, 200, $headers);
        }

        $batches = $query->orderByDesc('batch_date')
            ->orderBy('batch_no')
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Milk/Batches/Index', [
            'filters' => [
                'keyword' => $keyword,
                'batch_no' => $request->get('batch_no'),
                'person' => $request->get('person'),
                'from_date' => $request->get('from_date'),
                'to_date' => $request->get('to_date'),
            ],
            'batches' => $batches,
        ]);
    }

    public function show(MilkBatch $milkBatch): Response
    {
        return Inertia::render('Milk/Batches/Show', [
            'id' => $milkBatch->id,
            'batchNo' => $milkBatch->batch_no,
            'batch' => [
                'batch_date' => $milkBatch->batch_date->format('Y-m-d'),
                'person' => $milkBatch->person,
                'batch_no' => $milkBatch->batch_no,
                'volume_l' => $milkBatch->volume_l,
                'milk_unit_price' => $milkBatch->milk_unit_price,
                'milk_purchase_cost' => $milkBatch->milk_purchase_cost,
                'labour_cost' => $milkBatch->labour_cost,
                'other_expenses_total' => $milkBatch->other_expenses_total,
                'notes' => $milkBatch->notes,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_date' => ['required', 'date'],
            'person' => ['nullable', 'string', 'max:255'],
            'batch_no' => ['required', 'string', 'max:255', 'unique:milk_batches,batch_no'],
            'volume_l' => ['required', 'numeric', 'min:0'],
            'milk_unit_price' => ['required', 'numeric', 'min:0'],
            // labour_cost optional on create
            'labour_cost' => ['nullable', 'numeric', 'min:0'],
            'other_expenses_total' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $milkPurchaseCost = (float)$validated['milk_unit_price'] * (float)$validated['volume_l'];
        $labourCost = (float)($validated['labour_cost'] ?? 0);
        $otherExpenses = (float)($validated['other_expenses_total'] ?? 0);

        $batch = MilkBatch::create([
            'batch_date' => $validated['batch_date'],
            'person' => $validated['person'] ?? null,
            'batch_no' => $validated['batch_no'],
            'volume_l' => $validated['volume_l'],
            'milk_unit_price' => $validated['milk_unit_price'],
            'milk_purchase_cost' => $milkPurchaseCost,
            'labour_cost' => $labourCost,
            'other_expenses_total' => $otherExpenses,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Record combined expenses for dashboard/expenses page
        $totalExpenses = $milkPurchaseCost + $labourCost + $otherExpenses;
        Expense::create([
            'name' => 'Milk Batch ' . $batch->batch_no . ' Expenses',
            'description' => 'Auto-recorded expenses for milk batch #' . $batch->batch_no,
            'amount' => $totalExpenses,
            'expense_date' => $batch->batch_date,
        ]);

        return redirect()->route('milk.batches')
            ->with('success', 'Milk batch created successfully.');
    }

    public function update(Request $request, MilkBatch $milkBatch)
    {
        $validated = $request->validate([
            'batch_date' => ['required', 'date'],
            'person' => ['nullable', 'string', 'max:255'],
            'batch_no' => ['required', 'string', 'max:255', 'unique:milk_batches,batch_no,' . $milkBatch->id],
            'volume_l' => ['required', 'numeric', 'min:0'],
            'milk_unit_price' => ['required', 'numeric', 'min:0'],
            'labour_cost' => ['required', 'numeric', 'min:0'],
            'other_expenses_total' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $milkPurchaseCost = (float)$validated['milk_unit_price'] * (float)$validated['volume_l'];
        $milkBatch->update([
            'batch_date' => $validated['batch_date'],
            'person' => $validated['person'] ?? null,
            'batch_no' => $validated['batch_no'],
            'volume_l' => $validated['volume_l'],
            'milk_unit_price' => $validated['milk_unit_price'],
            'milk_purchase_cost' => $milkPurchaseCost,
            'labour_cost' => $validated['labour_cost'],
            'other_expenses_total' => (float)($validated['other_expenses_total'] ?? 0),
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'Milk batch updated successfully.');
    }

    public function destroy(MilkBatch $milkBatch)
    {
        // Delete associated expense record first
        Expense::where("name", "Milk Batch " . $milkBatch->batch_no . " Expenses")->delete();

        $milkBatch->delete();
        return redirect()->route('milk.batches')->with('success', 'Milk batch deleted successfully.');
    }
} 