<?php

namespace App\Http\Controllers;

use App\Enums\Category\CategoryFieldsEnum;
use App\Enums\Core\FilterFieldTypeEnum;
use App\Enums\Core\FilterResourceEnum;
use App\Enums\Core\SortOrderEnum;
use App\Enums\Product\ProductExpandEnum;
use App\Enums\Product\ProductFiltersEnum;
use App\Enums\Product\ProductSortFieldsEnum;
use App\Enums\Product\ProductStatusEnum;
use App\Enums\Supplier\SupplierFieldsEnum;
use App\Enums\UnitType\UnitTypeFieldsEnum;
use App\Exceptions\ProductNotFoundException;
use App\Helpers\BaseHelper;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $service)
    {
    }

    public function index(ProductIndexRequest $request): Response|StreamedResponse
    {
        $params = $request->validated();
        $params['expand'] = array_unique(array_merge($params['expand'] ?? [], [
            ProductExpandEnum::CATEGORY->value,
            ProductExpandEnum::SUPPLIER->value,
            ProductExpandEnum::UNIT_TYPE->value,
        ]));

        // Handle export
        if ($request->filled('export')) {
            $exportType = $request->get('export');
            // Get all items without pagination for export
            $allParams = $params;
            $allParams['per_page'] = 100000; // sufficiently large
            $page = $this->service->getAll($allParams);
            $rows = $page->items();

            $filename = 'products_' . now()->format('Ymd_His') . ($exportType === 'pdf' ? '.csv' : '.csv');
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            return response()->stream(function () use ($rows) {
                $out = fopen('php://output', 'w');
                fputcsv($out, ['ID', 'Name', 'Product Number', 'Product Code', 'Category', 'Quantity', 'Unit', 'Buying Price', 'Selling Price', 'Status']);
                foreach ($rows as $p) {
                    fputcsv($out, [
                        $p->id,
                        $p->name,
                        $p->product_number,
                        $p->product_code,
                        optional($p->category)->name,
                        $p->quantity,
                        optional($p->unit_type)->symbol,
                        $p->buying_price,
                        $p->selling_price,
                        $p->status,
                    ]);
                }
                fclose($out);
            }, 200, $headers);
        }

        return Inertia::render(
            component: 'Product/Index',
            props: [
                'products' => $this->service->getAll($params),
                'filters'  => [
                    ProductFiltersEnum::KEYWORD->value        => [
                        'label'       => ProductFiltersEnum::KEYWORD->label(),
                        'placeholder' => 'Enter keyword.',
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[ProductFiltersEnum::KEYWORD->value] ?? "",
                    ],
                    ProductFiltersEnum::NAME->value           => [
                        'label'       => ProductFiltersEnum::NAME->label(),
                        'placeholder' => 'Enter name.',
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[ProductFiltersEnum::NAME->value] ?? "",
                    ],
                    ProductFiltersEnum::PRODUCT_NUMBER->value => [
                        'label'       => ProductFiltersEnum::PRODUCT_NUMBER->label(),
                        'placeholder' => 'Enter product number.',
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[ProductFiltersEnum::PRODUCT_NUMBER->value] ?? "",
                    ],
                    ProductFiltersEnum::PRODUCT_CODE->value   => [
                        'label'       => ProductFiltersEnum::PRODUCT_CODE->label(),
                        'placeholder' => 'Enter product code.',
                        'type'        => FilterFieldTypeEnum::STRING->value,
                        'value'       => $request->validated()[ProductFiltersEnum::PRODUCT_CODE->value] ?? "",
                    ],
                    ProductFiltersEnum::CATEGORY_ID->value    => [
                        'label'         => ProductFiltersEnum::CATEGORY_ID->label(),
                        'placeholder'   => 'Select category.',
                        'type'          => FilterFieldTypeEnum::SELECT->value,
                        'value'         => $request->validated()[ProductFiltersEnum::CATEGORY_ID->value] ?? "",
                        'resource'      => FilterResourceEnum::CATEGORIES->value,
                        'resourceLabel' => CategoryFieldsEnum::NAME->value,
                    ],
                    ProductFiltersEnum::SUPPLIER_ID->value    => [
                        'label'         => ProductFiltersEnum::SUPPLIER_ID->label(),
                        'placeholder'   => 'Select supplier.',
                        'type'          => FilterFieldTypeEnum::SELECT->value,
                        'value'         => $request->validated()[ProductFiltersEnum::SUPPLIER_ID->value] ?? "",
                        'resource'      => FilterResourceEnum::SUPPLIERS->value,
                        'resourceLabel' => SupplierFieldsEnum::NAME->value,
                    ],
                    ProductFiltersEnum::BUYING_PRICE->value   => [
                        'label'       => ProductFiltersEnum::BUYING_PRICE->label(),
                        'placeholder' => 'Enter buying price.',
                        'type'        => FilterFieldTypeEnum::NUMBER_RANGE->value,
                        'value'       => $request->validated()[ProductFiltersEnum::BUYING_PRICE->value] ?? "",
                    ],
                    ProductFiltersEnum::SELLING_PRICE->value  => [
                        'label'       => ProductFiltersEnum::SELLING_PRICE->label(),
                        'placeholder' => 'Enter selling price.',
                        'type'        => FilterFieldTypeEnum::NUMBER_RANGE->value,
                        'value'       => $request->validated()[ProductFiltersEnum::SELLING_PRICE->value] ?? "",
                    ],
                    ProductFiltersEnum::BUYING_DATE->value    => [
                        'label'       => ProductFiltersEnum::BUYING_DATE->label(),
                        'placeholder' => 'Enter buying date.',
                        'type'        => FilterFieldTypeEnum::DATE_RANGE->value,
                        'value'       => $request->validated()[ProductFiltersEnum::BUYING_DATE->value] ?? "",
                    ],
                    ProductFiltersEnum::UNIT_TYPE_ID->value     => [
                        'label'         => ProductFiltersEnum::UNIT_TYPE_ID->label(),
                        'placeholder'   => 'Select unit type.',
                        'type'          => FilterFieldTypeEnum::SELECT->value,
                        'value'         => $request->validated()[ProductFiltersEnum::UNIT_TYPE_ID->value] ?? "",
                        'resource'      => FilterResourceEnum::UNIT_TYPES->value,
                        'resourceLabel' => UnitTypeFieldsEnum::NAME->value,
                    ],
                    ProductFiltersEnum::QUANTITIES->value     => [
                        'label'       => ProductFiltersEnum::QUANTITIES->label(),
                        'placeholder' => 'Enter range like: 10-100.',
                        'type'        => FilterFieldTypeEnum::NUMBER_RANGE->value,
                        'value'       => $request->validated()[ProductFiltersEnum::QUANTITIES->value] ?? "",
                    ],
                    ProductFiltersEnum::STATUS->value         => [
                        'label'       => ProductFiltersEnum::STATUS->label(),
                        'placeholder' => 'Select status.',
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()[ProductFiltersEnum::STATUS->value] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(ProductStatusEnum::choices()),
                    ],
                    "sort_by"                                 => [
                        'label'       => 'Sort By',
                        'placeholder' => 'Select a sort field',
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()['sort_by'] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(ProductSortFieldsEnum::choices()),
                    ],
                    "sort_order"                              => [
                        'label'       => 'Sort order',
                        'placeholder' => 'Select a sort order',
                        'type'        => FilterFieldTypeEnum::SELECT_STATIC->value,
                        'value'       => $request->validated()['sort_order'] ?? "",
                        'options'     => BaseHelper::convertKeyValueToLabelValueArray(SortOrderEnum::choices()),
                    ],
                    ProductFiltersEnum::CREATED_AT->value     => [
                        'label'       => ProductFiltersEnum::CREATED_AT->label(),
                        'placeholder' => 'Enter created at.',
                        'type'        => FilterFieldTypeEnum::DATETIME_RANGE->value,
                        'value'       => $request->validated()[ProductFiltersEnum::CREATED_AT->value] ?? "",
                    ],
                ],
            ]);
    }

    public function create(): Response
    {
        return Inertia::render(
            component: 'Product/Create'
        );
    }

    public function store(ProductCreateRequest $request): RedirectResponse
    {
        try {
            $this->service->create(
                payload: $request->validated()
            );
            $flash = [
                "message" => 'Product created successfully.'
            ];
        } catch (Exception $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => "Product creation failed!",
            ];

            Log::error("Product creation failed!", [
                "message" => $e->getMessage(),
                "traces"  => $e->getTrace()
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('flash', $flash);
    }

    public function edit(Product $product): Response|RedirectResponse
    {
        return Inertia::render(
            component: 'Product/Edit',
            props: [
                "product" => $product
            ]
        );
    }

    public function update(ProductUpdateRequest $request, $id): RedirectResponse
    {
        try {
            $this->service->update(
                id: $id,
                payload: $request->validated()
            );
            $flash = [
                "message" => 'Product updated successfully.'
            ];
        } catch (ProductNotFoundException $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => $e->getMessage(),
            ];
        } catch (Exception $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => "Product update failed!",
            ];

            Log::error("Product update failed!", [
                "message" => $e->getMessage(),
                "traces"  => $e->getTrace()
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('flash', $flash);
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->service->delete(id: $id);
            $flash = [
                "message" => 'Product deleted successfully.'
            ];
        } catch (ProductNotFoundException $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => $e->getMessage(),
            ];
        } catch (Exception $e) {
            $flash = [
                "isSuccess" => false,
                "message"   => "Product deletion failed!",
            ];

            Log::error("Product deletion failed!", [
                "message" => $e->getMessage(),
                "traces"  => $e->getTrace()
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('flash', $flash);
    }
}
