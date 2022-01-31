<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('orders', compact('user'));
        
    }
    public function repeatOrder()
    {
        $user = Auth::user();
        $mainAddress = Address::where('user_id', Auth::user()->id)->where('main', 1)->first();
        // $order = Product::has('orders')->get();
        
        $order_id = request('order_id');;
        $order = Order::find($order_id);

        $products = $order->products;

        $data = collect();
        $products->each(function($product) use ($data) {
            $data[$product->id] = $product->pivot->quantity;
        });

        session()->put('products', $data->toArray());
        return redirect()->route('basket');        
    }
}
