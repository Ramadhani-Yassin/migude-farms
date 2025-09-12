<?php

namespace App\Http\Requests\Product;

use App\Enums\Product\ProductFieldsEnum;
use App\Enums\Product\ProductStatusEnum;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\UnitType;
use App\Models\MilkBatch;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ProductCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ProductFieldsEnum::CATEGORY_ID->value   => [
                "bail",
                "required",
                "integer",
                Rule::exists((new Category())->getTable(), 'id')
            ],
            ProductFieldsEnum::SUPPLIER_ID->value   => [
                "bail",
                "nullable",
                "integer",
                Rule::exists((new Supplier())->getTable(), 'id')
            ],
            ProductFieldsEnum::MILK_BATCH_ID->value => [
                "bail",
                "required",
                "integer",
                Rule::exists((new MilkBatch())->getTable(), 'id')
            ],
            ProductFieldsEnum::NAME->value          => ["required", "string", "max:255"],
            ProductFieldsEnum::DESCRIPTION->value   => ["nullable", "string"],
            ProductFieldsEnum::PRODUCT_CODE->value  => ["nullable", "string", "max:255"],
            ProductFieldsEnum::ROOT->value          => ["nullable", "string", "max:255"],
            ProductFieldsEnum::BUYING_PRICE->value  => ["required", "numeric"],
            ProductFieldsEnum::SELLING_PRICE->value => ["required", "numeric", "gt:0"],
            ProductFieldsEnum::BUYING_DATE->value   => ["nullable", "date"],
            ProductFieldsEnum::UNIT_TYPE_ID->value  => [
                "required",
                "integer",
                Rule::exists((new UnitType())->getTable(), 'id')
            ],
            ProductFieldsEnum::QUANTITY->value      => ["required", "numeric", "gte:0"],
            ProductFieldsEnum::PHOTO->value         => ["nullable", "file", "mimes:jpg,jpeg,png,gif,svg", "max:1024"],
            ProductFieldsEnum::STATUS->value        => ["required", "string", Rule::in(ProductStatusEnum::values())],
        ];
    }

    protected function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            $batchId = $this->input(ProductFieldsEnum::MILK_BATCH_ID->value);
            $unitTypeId = $this->input(ProductFieldsEnum::UNIT_TYPE_ID->value);
            $quantity = (float)$this->input(ProductFieldsEnum::QUANTITY->value);

            if ($batchId && $unitTypeId && $quantity > 0) {
                $unit = \App\Models\UnitType::find($unitTypeId);
                $batch = \App\Models\MilkBatch::find($batchId);
                if ($unit && $batch) {
                    $unitVolume = (float)($unit->unit_volume ?? 1);
                    $required = $unitVolume * $quantity;
                    $available = (float)($batch->available_volume ?? $batch->volume_l);
                    if ($required > $available) {
                        $v->errors()->add(ProductFieldsEnum::QUANTITY->value, 'Insufficient batch volume for this production. Required: ' . number_format($required, 3) . ' L, Available: ' . number_format($available, 3) . ' L');
                    }
                }
            }
        });
    }
}
