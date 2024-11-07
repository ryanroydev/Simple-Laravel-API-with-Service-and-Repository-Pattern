<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
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
     * @param int $perPage The number of products per page.
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
     * @param array{name: string, description: string, price: float, quantity: int} $data
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
     * @param array{name: string, description: string, price: float} $data
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
     * Update the stock (quantity) of an existing product.
     *
     * @param int $id The ID of the product.
     * @param int $quantity The quantity to add (or subtract).
     * @return Product
     */
    public function updateStock(int $id, int $quantity): Product
    {
        $product =  Product::findOrFail($id);
        $product->quantity += $quantity;
        $product->save();

        return $product;
    }

    /**
     * Delete a product by its ID.
     *
     * @param int $id The ID of the product.
     * @return bool Returns true if the product was deleted successfully, false otherwise.
     */    
    public function delete(int $id): bool
    {
        $product =  Product::findOrFail($id);
        return $product->delete();
        
    }
}