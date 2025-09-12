<?php

namespace App\Services;

use App\Enums\Core\SortOrderEnum;
use App\Enums\Product\ProductFieldsEnum;
use App\Enums\Product\ProductFiltersEnum;
use App\Exceptions\DBCommitException;
use App\Exceptions\ProductNotFoundException;
use App\Helpers\ArrayHelper;
use App\Helpers\BaseHelper;
use App\Models\Product;
use App\Models\MilkBatch;
use App\Models\UnitType;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(
        private readonly ProductRepository  $repository,
        private readonly FileManagerService $fileManagerService
    )
    {
    }

    /**
     * @param array $queryParameters
     * @return LengthAwarePaginator
     */
    public function getAll(array $queryParameters): LengthAwarePaginator
    {
        $page = $queryParameters["page"] ?? 1;
        $perPage = BaseHelper::perPage($queryParameters["per_page"] ?? null);

        return $this->repository->getAll(
            page: $page,
            perPage: $perPage,
            filters: ArrayHelper::getFiltersValues($queryParameters, ProductFiltersEnum::values()),
            fields: $queryParameters["fields"] ?? [],
            expand: $queryParameters["expand"] ?? [],
            sortBy: $queryParameters["sort_by"] ?? ProductFieldsEnum::CREATED_AT->value,
            sortOrder: $queryParameters["sort_order"] ?? SortOrderEnum::DESC->value,
        );
    }

    /**
     * @param int $id
     * @param array $expands
     * @return Product|null
     * @throws ProductNotFoundException
     */
    public function findByIdOrFail(int $id, array $expands = []): ?Product
    {
        $product = $this->repository->find([
            ProductFiltersEnum::ID->value => $id
        ], $expands);

        if (!$product) {
            throw new ProductNotFoundException('Product not found by the given id.');
        }

        return $product;
    }

    /**
     * @param array $payload
     * @return mixed
     * @throws DBCommitException
     */
    public function create(array $payload): mixed
    {
        $photo = null;
        if (isset($payload['photo']) && $payload['photo']) {
            $photo = $this->fileManagerService->uploadFile(
                file: $payload['photo'],
                uploadPath: Product::PHOTO_PATH
            );
        }

        $processPayload = [
            ProductFieldsEnum::CATEGORY_ID->value    => $payload[ProductFieldsEnum::CATEGORY_ID->value],
            ProductFieldsEnum::SUPPLIER_ID->value    => $payload[ProductFieldsEnum::SUPPLIER_ID->value] ?? null,
            ProductFieldsEnum::MILK_BATCH_ID->value  => $payload[ProductFieldsEnum::MILK_BATCH_ID->value] ?? null,
            ProductFieldsEnum::NAME->value           => $payload[ProductFieldsEnum::NAME->value],
            ProductFieldsEnum::DESCRIPTION->value    => $payload[ProductFieldsEnum::DESCRIPTION->value],
            ProductFieldsEnum::PRODUCT_NUMBER->value => 'P-' . Str::random(5),
            ProductFieldsEnum::PRODUCT_CODE->value   => $payload[ProductFieldsEnum::PRODUCT_CODE->value] ?? null,
            ProductFieldsEnum::ROOT->value           => $payload[ProductFieldsEnum::ROOT->value] ?? null,
            ProductFieldsEnum::BUYING_PRICE->value   => $payload[ProductFieldsEnum::BUYING_PRICE->value],
            ProductFieldsEnum::SELLING_PRICE->value  => $payload[ProductFieldsEnum::SELLING_PRICE->value],
            ProductFieldsEnum::BUYING_DATE->value    => $payload[ProductFieldsEnum::BUYING_DATE->value],
            ProductFieldsEnum::UNIT_TYPE_ID->value   => $payload[ProductFieldsEnum::UNIT_TYPE_ID->value],
            ProductFieldsEnum::QUANTITY->value       => $payload[ProductFieldsEnum::QUANTITY->value],
            ProductFieldsEnum::PHOTO->value          => $photo,
            ProductFieldsEnum::STATUS->value         => $payload[ProductFieldsEnum::STATUS->value],
        ];

        return DB::transaction(function () use ($processPayload) {
            $product = $this->repository->create($processPayload);

            // Deduct milk batch available volume if linked
            if ($product->milk_batch_id && $product->unit_type_id && $product->quantity) {
                $unitType = UnitType::find($product->unit_type_id);
                $usedVolume = ($unitType?->unit_volume ?? 1) * (float)$product->quantity;
                if ($usedVolume > 0) {
                    $batch = MilkBatch::lockForUpdate()->find($product->milk_batch_id);
                    if (!$batch) {
                        throw new Exception('Milk batch not found.');
                    }
                    $available = (float)($batch->available_volume ?? $batch->volume_l);
                    if ($available <= 0 || $available < $usedVolume) {
                        throw new Exception('Insufficient batch volume for this production.');
                    }
                    // Only adjust available_volume, keep volume_l fixed as initial volume
                    $batch->decrement('available_volume', $usedVolume);
                }
            }

            return $product;
        });
    }

    /**
     * @param int $id
     * @param array $payload
     * @return Product
     * @throws ProductNotFoundException
     * @throws Exception
     */
    public function update(int $id, array $payload): Product
    {
        $product = $this->findByIdOrFail($id);

        $photo = $product->getRawOriginal(ProductFieldsEnum::PHOTO->value);
        if (isset($payload['photo'])) {
            $photo = $this->fileManagerService->uploadFile(
                file: $payload['photo'],
                uploadPath: Product::PHOTO_PATH,
                deleteFileName: $photo
            );
        }

        $processPayload = [
            ProductFieldsEnum::CATEGORY_ID->value   => $payload[ProductFieldsEnum::CATEGORY_ID->value] ?? $product->category_id,
            ProductFieldsEnum::SUPPLIER_ID->value   => $payload[ProductFieldsEnum::SUPPLIER_ID->value] ?? $product->supplier_id,
            ProductFieldsEnum::MILK_BATCH_ID->value => $payload[ProductFieldsEnum::MILK_BATCH_ID->value] ?? $product->milk_batch_id,
            ProductFieldsEnum::NAME->value          => $payload[ProductFieldsEnum::NAME->value] ?? $product->name,
            ProductFieldsEnum::DESCRIPTION->value   => $payload[ProductFieldsEnum::DESCRIPTION->value] ?? $product->description,
            ProductFieldsEnum::PRODUCT_CODE->value  => $payload[ProductFieldsEnum::PRODUCT_CODE->value] ?? $product->product_code,
            ProductFieldsEnum::ROOT->value          => $payload[ProductFieldsEnum::ROOT->value] ?? $product->root,
            ProductFieldsEnum::BUYING_PRICE->value  => $payload[ProductFieldsEnum::BUYING_PRICE->value] ?? $product->buying_price,
            ProductFieldsEnum::SELLING_PRICE->value => $payload[ProductFieldsEnum::SELLING_PRICE->value] ?? $product->selling_price,
            ProductFieldsEnum::BUYING_DATE->value   => $payload[ProductFieldsEnum::BUYING_DATE->value] ?? $product->buying_date,
            ProductFieldsEnum::UNIT_TYPE_ID->value  => $payload[ProductFieldsEnum::UNIT_TYPE_ID->value] ?? $product->unit_type_id,
            ProductFieldsEnum::QUANTITY->value      => $payload[ProductFieldsEnum::QUANTITY->value] ?? $product->quantity,
            ProductFieldsEnum::PHOTO->value         => $photo,
            ProductFieldsEnum::STATUS->value        => $payload[ProductFieldsEnum::STATUS->value] ?? $product->status,
        ];

        return DB::transaction(function () use ($product, $processPayload) {
            // Calculate previous used volume
            $prevUnit = UnitType::find($product->unit_type_id);
            $prevUsed = ($prevUnit?->unit_volume ?? 1) * (float)$product->quantity;
            $prevBatchId = $product->milk_batch_id;

            // Update product first
            $updated = $this->repository->update($product, $processPayload);

            // Calculate new used volume
            $newUnit = UnitType::find($updated->unit_type_id);
            $newUsed = ($newUnit?->unit_volume ?? 1) * (float)$updated->quantity;
            $newBatchId = $updated->milk_batch_id;

            // Adjust batch available volumes
            if ($prevBatchId && $newBatchId && $prevBatchId === $newBatchId) {
                $diff = $newUsed - $prevUsed; // positive means further deduction
                if ($diff !== 0.0) {
                    $batch = MilkBatch::lockForUpdate()->find($newBatchId);
                    if (!$batch) {
                        throw new Exception('Milk batch not found.');
                    }
                    if ($diff > 0) {
                        $available = (float)($batch->available_volume ?? $batch->volume_l);
                        if ($available < $diff) {
                            throw new Exception('Insufficient batch volume for this production update.');
                        }
                        $batch->decrement('available_volume', $diff);
                    } else {
                        $restore = abs($diff);
                        $batch->increment('available_volume', $restore);
                    }
                }
            } else {
                if ($prevBatchId && $prevUsed > 0) {
                    $prevBatch = MilkBatch::lockForUpdate()->find($prevBatchId);
                    if ($prevBatch) {
                        $prevBatch->increment('available_volume', $prevUsed);
                    }
                }
                if ($newBatchId && $newUsed > 0) {
                    $newBatch = MilkBatch::lockForUpdate()->find($newBatchId);
                    if (!$newBatch) {
                        throw new Exception('Milk batch not found.');
                    }
                    $available = (float)($newBatch->available_volume ?? $newBatch->volume_l);
                    if ($available < $newUsed) {
                        throw new Exception('Insufficient batch volume for this production update.');
                    }
                    $newBatch->decrement('available_volume', $newUsed);
                }
            }

            return $updated;
        });
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws ProductNotFoundException
     */
    public function delete(int $id): ?bool
    {
        $product = $this->findByIdOrFail($id);
        $photo = $product->getRawOriginal(ProductFieldsEnum::PHOTO->value);
        if ($photo) {
            $this->fileManagerService->delete(
                fileName: $photo,
                path: Product::PHOTO_PATH,
            );
        }

        // Todo: prevent delete for available orders

        return $this->repository->delete($product);
    }
}
