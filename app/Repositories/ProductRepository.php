<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ProductRepository
 *
 * A repository class for managing Product entities.
 *
 * @package App\Repositories
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Get a paginated list of products.
     *
     * @param int $per_page The number of products per page.
     * @return LengthAwarePaginator<Product>
     */
    public function getAllByPage(int $per_page): LengthAwarePaginator
    {
        return Product::paginate($per_page);
    }

    /**
     * Get a product by its ID.
     *
     * @param int $id The ID of the product.
     * @return Product
     */   
    public function getById(int $id): Product
    {
        return Product::findOrFail($id);
    }

    /**
     * Create a new product.
     *
     * @param array<mixed> $data
     * @return Product
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

   /**
     * Update an existing product by its ID.
     *
     * @param int $id The ID of the product.
     * @param array<mixed> $data
     * @return Product
     */
    public function update(int $id, array $data): Product
    {
        $product =  Product::findOrFail($id);
        $product->update($data);
        $product->save();

        return $product;
    }

    /**
     * Delete a product by its ID.
     *
     * @param int $id The ID of the product.
     * @return bool|null Returns true if the product was deleted successfully, false otherwise.
     */    
    public function delete(int $id): bool|null
    {
        $product =  Product::findOrFail($id);
        return $product->delete();
        
    }
}