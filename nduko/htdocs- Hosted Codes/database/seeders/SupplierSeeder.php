<?php

namespace Database\Seeders;

use App\Enums\Supplier\SupplierFieldsEnum;
use App\Exceptions\DBCommitException;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws DBCommitException
     */
    public function run(): void
    {
        if (Supplier::all()->count() >= 10) {
            return;
        }

        $files = File::files(public_path('assets/img/seeder/suppliers'));
        foreach ($files as $file) {
            $imageName = $file->getBasename();
            $imagePath = 'suppliers/' . $imageName;
            Storage::put($imagePath, $file->getContents());

            $base = pathinfo($imageName, PATHINFO_FILENAME);

            $suppliersPayload = [
                SupplierFieldsEnum::NAME->value       => ucwords(str_replace(['-', '_'], ' ', $base)),
                SupplierFieldsEnum::EMAIL->value      => $base . '@example.com',
                SupplierFieldsEnum::PHONE->value      => '0700' . rand(100000, 999999),
                SupplierFieldsEnum::ADDRESS->value    => 'Local Supplier',
                SupplierFieldsEnum::SHOP_NAME->value  => 'Dairy Supplies Co.',
                SupplierFieldsEnum::CREATED_AT->value => now(),
                "updated_at"                          => now(),
            ];

            Supplier::query()->updateOrCreate(
                [SupplierFieldsEnum::PHOTO->value => $imageName],
                $suppliersPayload
            );
        }
    }
}
