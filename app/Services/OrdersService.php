<?php

namespace App\Services;

use App\Repositories\OrdersRepositoryInterface;

class OrdersService
{
    public function __construct(
        protected OrdersRepositoryInterface $ordersRepository
    ) {}

    public function create(array $data)
    {
        return $this->ordersRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->ordersRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->ordersRepository->delete($id);
    }

    public function all()
    {
        return $this->ordersRepository->all();
    }

    public function find($id)
    {
        return $this->ordersRepository->find($id);
    }
}
