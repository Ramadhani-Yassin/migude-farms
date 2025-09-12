<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Milk\MilkBatchController;
use App\Http\Controllers\Milk\MilkProductController;
use App\Http\Controllers\Milk\MilkBatchLabourController;
use App\Http\Controllers\Milk\MilkBatchExpenseController;
use App\Http\Controllers\Milk\MilkProductionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->prefix('milk')->group(function () {
    // Batches
    Route::get('batches', [MilkBatchController::class, 'index']);
    Route::post('batches', [MilkBatchController::class, 'store']);
    Route::get('batches/{milkBatch}', [MilkBatchController::class, 'show']);
    Route::put('batches/{milkBatch}', [MilkBatchController::class, 'update']);
    Route::delete('batches/{milkBatch}', [MilkBatchController::class, 'destroy']);
    Route::get('batches/{milkBatch}/summary', [MilkBatchController::class, 'summary']);

    // Milk Products (variants)
    Route::get('products', [MilkProductController::class, 'index']);
    Route::post('products', [MilkProductController::class, 'store']);
    Route::put('products/{milkProduct}', [MilkProductController::class, 'update']);
    Route::delete('products/{milkProduct}', [MilkProductController::class, 'destroy']);

    // Labours
    Route::get('labours', [MilkBatchLabourController::class, 'index']);
    Route::post('labours', [MilkBatchLabourController::class, 'store']);
    Route::put('labours/{milkBatchLabour}', [MilkBatchLabourController::class, 'update']);
    Route::delete('labours/{milkBatchLabour}', [MilkBatchLabourController::class, 'destroy']);

    // Expenses
    Route::get('expenses', [MilkBatchExpenseController::class, 'index']);
    Route::post('expenses', [MilkBatchExpenseController::class, 'store']);
    Route::put('expenses/{milkBatchExpense}', [MilkBatchExpenseController::class, 'update']);
    Route::delete('expenses/{milkBatchExpense}', [MilkBatchExpenseController::class, 'destroy']);

    // Productions
    Route::get('productions', [MilkProductionController::class, 'index']);
    Route::post('productions', [MilkProductionController::class, 'store']);
    Route::put('productions/{milkProduction}', [MilkProductionController::class, 'update']);
    Route::delete('productions/{milkProduction}', [MilkProductionController::class, 'destroy']);
});
