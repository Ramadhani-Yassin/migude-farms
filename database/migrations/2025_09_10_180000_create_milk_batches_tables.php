<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('milk_batches', function (Blueprint $table) {
			$table->id();
			$table->date('batch_date');
			$table->string('batch_no')->unique();
			$table->string('person')->nullable();
			$table->decimal('volume_l', 20, 3); // collected volume in litres
			$table->decimal('milk_unit_price', 20, 3)->nullable(); // price per litre
			$table->decimal('milk_purchase_cost', 20, 2)->default(0);
			$table->decimal('labour_cost', 20, 2)->default(0);
			$table->decimal('other_expenses_total', 20, 2)->default(0);
			$table->decimal('total_sales_expected', 20, 2)->default(0);
			$table->decimal('profit_margin', 20, 2)->default(0);
			$table->text('notes')->nullable();
			$table->timestamps();
		});

		Schema::create('milk_batch_labours', function (Blueprint $table) {
			$table->id();
			$table->foreignId('milk_batch_id')->constrained('milk_batches')->cascadeOnDelete();
			$table->string('cost_centre'); // Production, Distribution, Packages, Marketing, etc.
			$table->string('person')->nullable();
			$table->string('job_title')->nullable();
			$table->decimal('daily_wage', 20, 2)->default(0);
			$table->decimal('days', 20, 2)->default(0);
			$table->decimal('total', 20, 2)->default(0);
			$table->date('labour_date')->nullable();
			$table->timestamps();
		});

		Schema::create('milk_batch_expenses', function (Blueprint $table) {
			$table->id();
			$table->foreignId('milk_batch_id')->constrained('milk_batches')->cascadeOnDelete();
			$table->string('cost_centre');
			$table->string('item');
			$table->decimal('unit_price', 20, 2)->default(0);
			$table->decimal('units', 20, 3)->default(0);
			$table->decimal('total', 20, 2)->default(0);
			$table->date('expense_date')->nullable();
			$table->timestamps();
		});

		Schema::create('milk_products', function (Blueprint $table) {
			$table->id();
			$table->string('name'); // Fresh Milk, Fermented Milk, Yoghurt, etc.
			$table->decimal('base_quantity_l', 20, 3); // litre size represented by this product variant (e.g., 5L, 0.25L)
			$table->string('unit_label'); // e.g., "Yoghurt 5L", "Plain Greek 250 mL"
			$table->decimal('selling_price', 20, 2);
			$table->decimal('packaging_cost', 20, 2)->default(0);
			$table->decimal('net_price', 20, 2)->default(0);
			$table->boolean('active')->default(true);
			$table->timestamps();
		});

		Schema::create('milk_productions', function (Blueprint $table) {
			$table->id();
			$table->foreignId('milk_batch_id')->constrained('milk_batches')->cascadeOnDelete();
			$table->foreignId('milk_product_id')->constrained('milk_products')->cascadeOnDelete();
			$table->decimal('produced_units', 20, 3)->default(0); // number of sellable units produced of this size
			$table->decimal('milk_consumed_l', 20, 3)->default(0); // litres consumed from batch
			$table->timestamps();
		});

		Schema::create('milk_stock_movements', function (Blueprint $table) {
			$table->id();
			$table->morphs('reference'); // reference_type, reference_id: orders, manual_adjustment, production
			$table->foreignId('milk_product_id')->constrained('milk_products')->cascadeOnDelete();
			$table->foreignId('milk_batch_id')->nullable()->constrained('milk_batches')->nullOnDelete();
			$table->enum('direction', ['in', 'out']);
			$table->decimal('quantity_units', 20, 3); // units moved
			$table->decimal('milk_equiv_l', 20, 3)->default(0); // litres equivalent
			$table->text('note')->nullable();
			$table->timestamps();
		});

		Schema::create('milk_claims', function (Blueprint $table) {
			$table->id();
			$table->date('claim_date');
			$table->string('person');
			$table->string('cost_centre');
			$table->string('item');
			$table->decimal('price', 20, 2)->default(0);
			$table->decimal('units', 20, 3)->default(0);
			$table->decimal('amount', 20, 2)->default(0);
			$table->decimal('paid_amount', 20, 2)->default(0);
			$table->decimal('balance', 20, 2)->default(0);
			$table->string('batch_no')->nullable();
			$table->text('notice')->nullable();
			$table->timestamps();
		});

		// Link POS sales to milk batches when applicable
		Schema::table('order_items', function (Blueprint $table) {
			if (!Schema::hasColumn('order_items', 'milk_batch_id')) {
				$table->foreignId('milk_batch_id')->nullable()->after('product_id')->constrained('milk_batches')->nullOnDelete();
			}
		});
	}

	public function down(): void
	{
		Schema::table('order_items', function (Blueprint $table) {
			if (Schema::hasColumn('order_items', 'milk_batch_id')) {
				$table->dropConstrainedForeignId('milk_batch_id');
			}
		});

		Schema::dropIfExists('milk_claims');
		Schema::dropIfExists('milk_stock_movements');
		Schema::dropIfExists('milk_productions');
		Schema::dropIfExists('milk_products');
		Schema::dropIfExists('milk_batch_expenses');
		Schema::dropIfExists('milk_batch_labours');
		Schema::dropIfExists('milk_batches');
	}
}; 