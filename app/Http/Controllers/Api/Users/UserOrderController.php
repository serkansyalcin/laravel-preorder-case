<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Services\OrderItemsService;
use App\Services\OrdersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserOrderController extends Controller
{
    public function __construct(protected OrdersService $ordersService, protected OrderItemsService $orderItemsService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$order = $this->ordersService->all();
        $order = Order::with(['users', 'orderItems', 'orderItems.product'])->where('user_id', Auth::user()->id)->get();

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

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'billing_address' => 'required|string',
            'shipping_address' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:\App\Models\Product,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }
        //dd($request->all());

        $order_number = Str::upper(Str::random(10));

        $orderData = [
            'user_id' => $user->id,
            'order_number' => $order_number,
            'amount' => 0,
            'total_product' => count($request->items),
            'total_purchase_qty' => collect($request->items)->sum('qty'),
            'billing_address' => trim($request->billing_address),
            'shipping_address' => trim($request->shipping_address) ?? trim($request->billing_address),
            'status' => 'pending',
        ];

        $orderCreate = $this->ordersService->create($orderData);

        if (!$orderCreate) {
            return response()->json(['message' => 'Order not created'], 404);
        }

        $totalAmount = 0;

        // Create order items
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $totalAmount += $product->price * $item['qty'];

            $orderItemsData = [
                'order_id' => $orderCreate->id,
                'category_id' => $product->category_id,
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'price' => $product->price,
            ];
            $orderItemCreate = $this->orderItemsService->create($orderItemsData);
        }

        // Update the total amount in the order
        $orderUpdate = $this->ordersService->update(['amount' => $totalAmount], $orderCreate->id);

        return response()->json([
            'data' => $orderUpdate,
            'message' => "Order created successfully."
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //$order = $this->ordersService->find($id);
        $order = Order::where('user_id', Auth::user()->id)->where('id', $id)->get();

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
}
