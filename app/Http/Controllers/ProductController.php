<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('product')
                ->join('categories', 'categories.category_id', '=', 'product.category_id')
                ->select('product.product_id','categories.category_name','product.product_name','product.product_price','product.product_stock','product.explanation')
                ->get();
        return view('product/list', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('product/form', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['category_id' => 'required',
                        'product_name' => 'required',
                        'product_price' => 'required',
                        'product_stock' => 'required']);
        $price = $request->input('product_price');
        $price = str_replace("Rp ","",$price);
        $price = str_replace(".","",$price);
        Product::create(['product_id' => '0',
                        'category_id' => e($request->input('category_id')),
                        'product_name' => e($request->input('product_name')),
                        'product_price' => $price,
                        'product_stock' => e($request->input('product_stock')),
                        'explanation' => e($request->input('explanation')) ]);
        return redirect()->route('product.index')->with('inserted',$request->input('product_name'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::find($id);
        return view('/product/edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(['category_id' => 'required',
                        'product_name' => 'required',
                        'product_price' => 'required',
                        'product_stock' => 'required']);
        $product = Product::find($id);
        $price = $request->input('product_price');
        $price = str_replace("Rp ","",$price);
        $price = str_replace(".","",$price);
        $product->category_id = e($request->input('category_id'));
        $product->product_name = e($request->input('product_name'));
        $product->product_price = $price;
        $product->product_stock = e($request->input('product_stock'));
        $product->explanation = e($request->input('explanation'));
        $product->save();
        return redirect()->route('product.index')->with('edited',$request->input('product_name'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('product.index')->with('deleted',$id);
    }
}
