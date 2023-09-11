<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Order;

use Auth;

class OrderController extends Controller
{
    public function getOrder(Product $product)
    {
        //display order form
        $order = new Order;
        return view('pages.order', compact('product','order'));
    }

    public function postOrder(Request $request)
    {
        $order = new Order;
        $user = Auth::user();

        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|min:0|integer',
            'note' => 'nullable',
            'proof' => 'required|mimes:jpeg,jpg,png,pdf|max:10000',
        ]);

        $product = Product::find($request['product_id']);

        $order->user_id = $user->id;
        $order->product_id = $request['product_id'];
        $order->quantity = $request['quantity'];
        $order->total = $product->price * $request['quantity'];
        $order->note = $request['note'];

        //save file
        $proof_name = 'proof_'.time().'.'.$request->proof->getClientOriginalExtension();
        $directory = $_SERVER['DOCUMENT_ROOT'].'/uploads/proof';
        if(!file_exists($directory)){
            mkdir($directory, 0755, true);
        }
        $file = $request['proof'];
        $file->move($directory, $proof_name);

        $order->proof = $proof_name;
        $order->save();

        Session()->flash('message', 'Your order has been submitted!');

        return redirect()->route('myorder');
    }

    public function myorder()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();
        return view('pages.myorder', compact('orders'));

    }
}
