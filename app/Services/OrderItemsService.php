<?php

namespace App\Services;

use App\Repositories\OrderItemsRepositoryInterface;

class OrderItemsService
{
    public function __construct(
        protected OrderItemsRepositoryInterface $orderItemsRepository
    ) {}

    public function create(array $data)
    {
        return $this->orderItemsRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->orderItemsRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->orderItemsRepository->delete($id);
    }

    public function all()
    {
        return $this->orderItemsRepository->all();
    }

    public function find($id)
    {
        return $this->orderItemsRepository->find($id);
    }
}
