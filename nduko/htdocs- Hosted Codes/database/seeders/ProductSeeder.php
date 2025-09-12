<?php

namespace Database\Seeders;

use App\Enums\Product\ProductFieldsEnum;
use App\Enums\Product\ProductStatusEnum;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\UnitType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();
        $unitTypes = UnitType::all();

        if ($suppliers->isEmpty() || $unitTypes->isEmpty()) {
            $this->command?->warn('Suppliers or Unit Types missing; skipping Product seeding.');
            return;
        }

        $catalog = [
            ['name' => 'Cow Milk (Fresh)', 'category' => 'Cow Milk', 'unit_symbol' => 'l', 'buying' => 1200, 'selling' => 1500, 'qty' => 500],
            ['name' => 'Buffalo Milk (Fresh)', 'category' => 'Buffalo Milk', 'unit_symbol' => 'l', 'buying' => 1400, 'selling' => 1700, 'qty' => 300],
            ['name' => 'Ghee (Cow)', 'category' => 'Ghee', 'unit_symbol' => 'kg', 'buying' => 18000, 'selling' => 22000, 'qty' => 50],
            ['name' => 'Butter (Salted)', 'category' => 'Butter', 'unit_symbol' => 'kg', 'buying' => 12000, 'selling' => 15000, 'qty' => 60],
            ['name' => 'Cheddar Cheese', 'category' => 'Cheese', 'unit_symbol' => 'kg', 'buying' => 16000, 'selling' => 20000, 'qty' => 40],
            ['name' => 'Paneer', 'category' => 'Paneer', 'unit_symbol' => 'kg', 'buying' => 12000, 'selling' => 15500, 'qty' => 70],
            ['name' => 'Yogurt Cup 500ml', 'category' => 'Yogurt / Curd', 'unit_symbol' => 'ml', 'buying' => 1200, 'selling' => 1500, 'qty' => 400],
            ['name' => 'Fresh Cream 250ml', 'category' => 'Cream', 'unit_symbol' => 'ml', 'buying' => 1500, 'selling' => 2000, 'qty' => 200],
            ['name' => 'Skimmed Milk Powder 1kg', 'category' => 'Skimmed Milk', 'unit_symbol' => 'kg', 'buying' => 18000, 'selling' => 23000, 'qty' => 80],
        ];

        foreach ($catalog as $item) {
            $category = Category::query()->where('name', $item['category'])->first();
            $unit = UnitType::query()->where('symbol', $item['unit_symbol'])->first();
            if (!$category || !$unit) continue;

            Product::query()->updateOrCreate(
                [
                    ProductFieldsEnum::NAME->value => $item['name'],
                ],
                [
                    ProductFieldsEnum::CATEGORY_ID->value    => $category->id,
                    ProductFieldsEnum::SUPPLIER_ID->value    => $suppliers->random()->id,
                    ProductFieldsEnum::PRODUCT_NUMBER->value => 'P-' . Str::random(5),
                    ProductFieldsEnum::DESCRIPTION->value    => $item['name'],
                    ProductFieldsEnum::PRODUCT_CODE->value   => Str::upper(Str::random(5)),
                    ProductFieldsEnum::ROOT->value           => 'Dairy',
                    ProductFieldsEnum::BUYING_PRICE->value   => $item['buying'],
                    ProductFieldsEnum::SELLING_PRICE->value  => $item['selling'],
                    ProductFieldsEnum::BUYING_DATE->value    => now()->subDays(rand(1, 30)),
                    ProductFieldsEnum::UNIT_TYPE_ID->value   => $unit->id,
                    ProductFieldsEnum::QUANTITY->value       => $item['qty'],
                    ProductFieldsEnum::PHOTO->value          => 'default-image.jpg',
                    ProductFieldsEnum::STATUS->value         => ProductStatusEnum::ACTIVE->value,
                    ProductFieldsEnum::CREATED_AT->value     => now(),
                    'updated_at'                             => now(),
                ]
            );
        }
    }
}
