<?php

namespace Database\Seeders;

use App\Models\MilkProduct;
use Illuminate\Database\Seeder;

class MilkProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Fresh Milk', 'base_quantity_l' => 1.000, 'unit_label' => 'Bottle 1L', 'selling_price' => 2000, 'packaging_cost' => 200],
            ['name' => 'Fresh Milk', 'base_quantity_l' => 0.500, 'unit_label' => 'Bottle 500ml', 'selling_price' => 1200, 'packaging_cost' => 150],
            ['name' => 'Yogurt', 'base_quantity_l' => 0.250, 'unit_label' => 'Cup 250ml', 'selling_price' => 1000, 'packaging_cost' => 100],
            ['name' => 'Ghee', 'base_quantity_l' => 0.250, 'unit_label' => 'Jar 250ml', 'selling_price' => 6000, 'packaging_cost' => 500],
            ['name' => 'Butter', 'base_quantity_l' => 0.250, 'unit_label' => 'Pack 250g', 'selling_price' => 3500, 'packaging_cost' => 200],
            ['name' => 'Paneer', 'base_quantity_l' => 0.250, 'unit_label' => 'Pack 250g', 'selling_price' => 4000, 'packaging_cost' => 200],
        ];

        foreach ($items as $it) {
            $payload = [
                'name' => $it['name'],
                'base_quantity_l' => $it['base_quantity_l'],
                'unit_label' => $it['unit_label'],
                'selling_price' => $it['selling_price'],
                'packaging_cost' => $it['packaging_cost'],
                'net_price' => $it['selling_price'] - $it['packaging_cost'],
                'active' => true,
            ];
            MilkProduct::query()->updateOrCreate([
                'name' => $it['name'],
                'unit_label' => $it['unit_label'],
            ], $payload);
        }
    }
} 