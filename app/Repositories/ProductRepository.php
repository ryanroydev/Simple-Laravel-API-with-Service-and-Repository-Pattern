<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllByPage(int $per_page): LengthAwarePaginator
    {
        return Product::paginate($per_page);
    }

    public function getById(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): Product
    {
        $product =  Product::findOrFail($id);
        $product->update($data);
        return $product->save();
    }

    public function delete(int $id): bool
    {
        $product =  Product::findOrFail($id);
        return $product->delete();
        
    }
}