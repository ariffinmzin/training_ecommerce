<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product_index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product;
        return view('admin.product_form', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;

        $this->validate($request, [
            'name' => 'required|min:3',
            'description' => 'nullable',
            'sku' => 'nullable',
            'photo' => 'nullable|mimes:jpeg,jpg,png|max:10000',
            'price' => 'required|numeric|min:0',
        ]);

        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->sku = $request['sku'];
        $product->price = $request['price'];

        //save photo
        $image_name = 'product_'.time().'.'.$request->photo->getClientOriginalExtension();
        $directory = $_SERVER['DOCUMENT_ROOT'].'/uploads/products';
        if(!file_exists($directory)){
            mkdir($directory, 0755, true);
        }

        $img = Image::make($request->photo->getRealPath());
        $img->fit(300, 300, function($constraint) {
            $constraint->aspectRatio();
        })->save($directory . '/' . $image_name, 80);

        $product->photo = $image_name;
        $product->save();

        Session()->flash('message', 'Your product has been saved!');

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.product_form', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'description' => 'nullable',
            'sku' => 'nullable',
            'photo' => 'nullable|mimes:jpeg,jpg,png|max:10000',
            'price' => 'required|numeric|min:0',
        ]);

        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->sku = $request['sku'];
        $product->price = $request['price'];

        //save photo
        $image_name = 'product_'.time().'.'.$request->photo->getClientOriginalExtension();
        $directory = $_SERVER['DOCUMENT_ROOT'].'/uploads/products';
        if(!file_exists($directory)){
            mkdir($directory, 0755, true);
        }

        $img = Image::make($request->photo->getRealPath());
        $img->fit(300, 300, function($constraint) {
            $constraint->aspectRatio();
        })->save($directory . '/' . $image_name, 80);

        $product->photo = $image_name;

        $product->save();

        Session()->flash('message', 'Your product has been saved!');

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        Session()->flash('message', 'Your product has been deleted!');

        return redirect()->route('product.index');
    }
}
