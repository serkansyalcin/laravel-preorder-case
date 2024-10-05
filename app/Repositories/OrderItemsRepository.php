<?php

namespace App\Repositories;

use App\Models\OrderItems;

class OrderItemsRepository implements OrderItemsRepositoryInterface
{
    public function all()
    {
        return OrderItems::all();
    }

    public function create(array $data)
    {
        return OrderItems::create($data);
    }

    public function update(array $data, $id)
    {
        $orderItems = OrderItems::findOrFail($id);
        $orderItems->update($data);
        return $orderItems;
    }

    public function delete($id)
    {
        $orderItems = OrderItems::findOrFail($id);
        $orderItems->delete();
    }

    public function find($id)
    {
        return OrderItems::find($id);
    }
}
