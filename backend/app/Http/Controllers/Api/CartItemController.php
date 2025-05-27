<?php

// app/Http/Controllers/Api/CartController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Http\Resources\CartItemResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartItemController extends Controller
{
    public function index()
    {
        return CartItem::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric'
        ]);
        return CartItem::create($validated);
    }

    public function show(CartItem $cartItem)
    {
        return $cartItem;
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $cartItem->update($request->all());
        return $cartItem;
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
        return response()->noContent();
    }

    public function getUserCart($userId)
    {
        return CartItem::where('user_id', $userId)->with('product')->get();
    }
}
