<?php

namespace Database\Seeders;

use App\Enums\Category\CategoryFieldsEnum;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Raw Milk',
            'Cow Milk',
            'Buffalo Milk',
            'Ghee',
            'Butter',
            'Cheese',
            'Paneer',
            'Yogurt / Curd',
            'Skimmed Milk',
            'Cream',
        ];

        foreach ($categories as $name) {
            $categoriesPayload = [
                CategoryFieldsEnum::NAME->value => $name,
            ];

            Category::query()->updateOrCreate(
                $categoriesPayload,
            );
        }
    }
}
