<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrderRequest;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('user')->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function create(): View
    {
        $users = User::all();
        $products = Product::where('stock', '>', 0)->get();
        $settings = Setting::first();

        return view('admin.orders.create', compact('users', 'products', 'settings'));
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $settings = Setting::first();
        $items = collect($request->products);

        $subTotal = $items->sum(fn($item) => $item['qty'] * Product::find($item['id'])->price);
        $tax = round($subTotal * ($settings->tax / 100), 2);
        $total = $subTotal + $tax + $settings->shipping;

        $order = Order::create([
            'invoice_no' => 'INV-' . now()->format('YmdHis'),
            'user_id' => $request->user_id,
            'sub_total' => $subTotal,
            'tax' => $tax,
            'shipping' => $settings->shipping,
            'total_price' => $total,
            'payment_status' => 2,
            'payment_method' => $request->payment_method,
            'tracking' => 1,
            'address' => $request->address,
            'building' => $request->building,
            'apartment' => $request->apartment,
            'floor' => $request->floor,
        ]);

        foreach ($items as $item) {
            $product = Product::find($item['id']);
            $order->products()->attach($product->id, [
                'quantity' => $item['qty'],
                'price' => $product->price,
            ]);
            $product->decrement('stock', $item['qty']);
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order #' . $order->invoice_no . ' created.');
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'products', 'transactions']);

        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(UpdateOrderRequest $request, Order $order): RedirectResponse
    {
        $order->update($request->only(['tracking', 'payment_status']));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order updated.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted.');
    }
}