<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order as MOrder;
use Illuminate\Support\Facades\Validator;

class Order extends Controller
{
    //
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric',
        ]);

        $errors = [];
        foreach ($validator->errors()->messages() as $error) {
            foreach ($error as $err_item) {
                array_push($errors, $err_item);
            }
        }

        if ($validator->fails()) {
            return response([
                'errors' => $errors,
            ], 400);
        }

        $product_id = $request->product_id;
        $validated = $validator->safe();
        $quantity = $validated->quantity;
        $user_id = $request->user()->id;

        $product = Product::where('id', $product_id)->first();

        if (!$product) {
            return response(['errors' => "product_id $product_id not exist!"], 400);
        }

        if (!$quantity) {
            return response(['errors' => "Cannot create an order with a quantity of 0"], 400);
        }

        if ($quantity >= $product->available_stock) {
            return response(['errors' => "Failed to order this product due to unavailability of the stock"], 400);
        }

        $user_id = $request->user()->id;

        $order = MOrder::create([
            'quantity' => $quantity,
            'product_id' => $product_id,
            'user_id' => $user_id
        ]);

        if (!$order) {
            return response(['errors' => 'Cannot create an order please try again.'], 400);
        }

        $product->update([
            'available_stock' => $product->available_stock - $quantity
        ]);

        $product->refresh();

        return response(['message' => 'You have successfully ordered this product'], 201);
    }
}