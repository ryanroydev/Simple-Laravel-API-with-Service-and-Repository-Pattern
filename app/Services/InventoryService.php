<?php
namespace App\Services;

use App\Repositories\ProductRepositoryInterface;

class InventoryService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function updateProduct(int $productId, array $data)
    {
        return $this->productRepository->update($productId, $data);
    }


    public function updateProductStock(int $productId, int $quantity)
    {
        $product = $this->productRepository->getById($productId);
        $product->quantity += $quantity;
        return $this->productRepository->update($productId, ['quantity' => $product->quantity]);
    }

    public function getInventory(int $per_page)
    {
        return $this->productRepository->getAllByPage($per_page);
    }

    public function getProduct(int $productId)
    {
        return $this->productRepository->getById($productId);
    }

    public function deleteProduct(int $productId)
    {
        return $this->productRepository->delete($productId);
    }
}
