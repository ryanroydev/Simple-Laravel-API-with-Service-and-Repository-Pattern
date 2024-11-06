<?php
namespace App\Repositories;

use app\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

Interface ProductRepositoryInterface
{
    public function getAllByPage(int $per_page): LengthAwarePaginator;
    public function getById(int $id): Product;
    public function create(array $data): Product;
    public function update(int $id, array $data): Product;
    public function delete(int $id): bool;
}