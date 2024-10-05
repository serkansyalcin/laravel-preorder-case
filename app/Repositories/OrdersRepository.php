<?php

namespace App\Repositories;

use App\Models\Order;

class OrdersRepository implements OrdersRepositoryInterface
{
    public function all()
    {
        return Order::all();
    }

    public function create(array $data)
    {
        return Order::create($data);
    }

    public function update(array $data, $id)
    {
        $orders = Order::findOrFail($id);
        $orders->update($data);
        return $orders;
    }

    public function delete($id)
    {
        $orders = Order::findOrFail($id);
        $orders->delete();
    }

    public function find($id)
    {
        return Order::find($id);
    }
}
