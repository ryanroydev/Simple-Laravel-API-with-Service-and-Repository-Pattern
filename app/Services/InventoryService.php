<?php
namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class InventoryService
{
    protected  ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Create new Product
     * 
     * @param array<mixed> $data
     * @return Product
     */
    public function createProduct(array $data) : Product
    {
        return $this->productRepository->create($data);
    }

    /**
     * Update Product
     * 
     * @param int $productId
     * @param array<mixed> $data
     * @return Product
     */
    public function updateProduct(int $productId, array $data) : Product
    {
        return $this->productRepository->update($productId, $data);
    }

    /**
     * Update the Product Stock
     * 
     * @param int $productId
     * @param int $quantity
     * @return Product
     */
    public function updateProductStock(int $productId, int $quantity) : Product
    {
        $product = $this->productRepository->getById($productId);
        $product->quantity += $quantity;
        return $this->productRepository->update($productId, ['quantity' => $product->quantity]);
    }

    /**
     * Get a paginated list of products.
     *
     * @param int $per_page The number of products per page.
     * @return LengthAwarePaginator<Product>
     */
    public function getInventory(int $per_page) : LengthAwarePaginator
    {
        return $this->productRepository->getAllByPage($per_page);
    }

    /**
     * Get a product by its ID.
     *
     * @param int $productId The ID of the product.
     * @return Product
     */   
    public function getProduct(int $productId) : Product
    {
        return $this->productRepository->getById($productId);
    }

    /**
     * Delete a product by its ID.
     *
     * @param int $productId The ID of the product.
     * @return bool|null Returns true if the product was deleted successfully, false otherwise.
     */
    public function deleteProduct(int $productId) : bool|null
    {
        return $this->productRepository->delete($productId);
    }
}
