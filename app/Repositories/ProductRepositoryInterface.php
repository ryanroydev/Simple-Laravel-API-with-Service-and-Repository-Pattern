<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

Interface ProductRepositoryInterface
{
    /**
     * Get a paginated list of products.
     *
     * @param int $per_page The number of products per page.
     * @return LengthAwarePaginator<Product>
     */  
    public function getAllByPage(int $per_page): LengthAwarePaginator|Product;

    /**
     * Get a product by its ID.
     *
     * @param int $id The ID of the product.
     * @return Product
     */       
    public function getById(int $id): Product;

    /**
     * Create a new product.
     *
     * @param array<mixed> $data
     * @return Product
     */
    public function create(array $data): Product;

   /**
     * Update an existing product by its ID.
     *
     * @param int $id The ID of the product.
     * @param array<mixed> $data
     * @return Product
     */
    public function update(int $id, array $data): Product;

    /**
     * Update the stock (quantity) of an existing product.
     *
     * @param int $id The ID of the product.
     * @param int $quantity The quantity to add (or subtract).
     * @return Product
     */
    public function updateStock(int $id, int $quantity): Product;

    /**
     * Delete a product by its ID.
     *
     * @param int $id The ID of the product.
     * @return bool|null Returns true if the product was deleted successfully, false otherwise.
     */  
    public function delete(int $id): bool|null;
}