<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\InventoryService;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ProductUpdateStockRequest;

class ProductController extends Controller
{
    private InventoryService $inventoryService;
    
    public function __construct(InventoryService $inventoryService) {

        $this->inventoryService = $inventoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {   
        $per_page =  (int) $request->input('per_page', 10);
        
        $products = $this->inventoryService->getInventory($per_page);
        
        return response()->success('Products fetched successfully', $products);
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductStoreRequest $request)  : JsonResponse
    {
        $product = $this->inventoryService->createProduct($request->validated());
        
        return response()->success('Product created successfully', $product);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)  : JsonResponse
    {
        $product = $this->inventoryService->getProduct((int) $id);

        return response()->success('Product details fetched successfully', $product);
    }

   /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductUpdateRequest $request, string $id)  : JsonResponse
    {
        $product = $this->inventoryService->updateProduct((int) $id, $request->validated());

        return response()->success('Product updated successfully', $product);
    }

    /**
     * Update Product Stock.
     *
     * @param ProductUpdateStockRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStock(ProductUpdateStockRequest $request, string $id)  : JsonResponse
    {
        $data = $request->validated();
        $product = $this->inventoryService->updateProductStock((int) $id, (int) $data['quantity']);

        return response()->success('Product stock updated successfully', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)  : JsonResponse
    {
        $this->inventoryService->deleteProduct((int) $id);

        return response()->success("Product deleted successfully", []);
    }
}
