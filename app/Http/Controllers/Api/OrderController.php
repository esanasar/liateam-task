<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $orderService;

    public function __construct(OrderRepositoryInterface $orderRepository, OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $orders = $this->orderRepository->all();
        return response()->json($orders);

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
//        $request->validate([
//            'products' => 'required|array',
//            'products.*.id' => 'required|exists:products,_id',
//            'products.*.count' => 'required|integer|min:1',
//        ]);

        $order = $this->orderService->createOrder(auth()->id(), $request->products);

        return response()->json($order, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = $this->orderRepository->find($id);
        return response()->json($order);
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
        $productRepository = new ProductRepository();

        $order = $this->orderRepository->find($id);
        foreach ($order->products as $productData) {
            $product = $productRepository->find($productData['id']);
            $product->inventory += $productData['count'];
            $product->save();
        }

        $this->orderRepository->delete($id);
        return response()->noContent();
    }
}
