<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusMail;
use App\Models\Order;
use App\Services\OrdersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct(protected OrdersService $ordersService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$order = $this->ordersService->all();
        $order = Order::with('users', 'orderItems')->get();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json([
            'data' => $order,
            'message' => "Order listing."
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //$order = $this->ordersService->find($id);
        $order = Order::with('users', 'orderItems')->where('id', $id)->get();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json([
            'data' => $order,
            'message' => "Order founds"
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    /**
     * Update Status the specified resource in storage.
     */
    public function updateStatus(Request $request, string $id)
    {
        $request->request->add(['id' => $id]);

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:\App\Models\Order,id',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }

        $orders = $this->ordersService->update([
            'status' => $request->status
        ], $id);

        if (!$orders) {
            return response()->json(['message' => 'Order not updated'], 404);
        }

        $getData = Order::with('users')->where('id', $id)->first();
        if (isset($getData) && !empty($getData)) {
            $userData = $getData->users;
            $data = [
                'user' =>  $userData,
                'order' => $orders
            ];
            Mail::to($userData->email)->send(new OrderStatusMail($data));
        }

        return response()->json([
            'data' => $orders,
            'message' => "Order updated successfully."
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function userOrder(string $user_id, string $order_id = null)
    {
        //$order = $this->ordersService->find($id);
        $order = Order::with('users', 'orderItems')->where(function ($query) use ($user_id, $order_id) {
            $query->where('user_id', $user_id);
            if (!empty($order_id)) {
                $query->where('id', $order_id);
            }
        })->get();

        if (!$order) {
            return response()->json(['message' => 'User order details not found'], 404);
        }

        return response()->json([
            'data' => $order,
            'message' => "User order details founds"
        ], 200);
    }
}
