<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
        if(Session::get('login') && ((Session('type') == 4 || Session('type') == 2) || (Session('type') == 1))){
        $products = DB::table('product')
                ->join('categories', 'categories.category_id', '=', 'product.category_id')
                ->select('product.*','categories.category_name')
                ->get();
        return view('product/list', ['products' => $products]);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Session::get('login') && (Session('type') == 4)){
        $categories = Category::where('status',1)->get();
        return view('product/form', ['categories' => $categories]);
    }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
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
        if(Session::get('login') && (Session('type') == 4)){
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
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Session::get('login') && (Session('type') == 4)){
        $categories = Category::where('status',1)->get();
        $product = Product::find($id);
        return view('/product/edit', ['product' => $product, 'categories' => $categories]);
    }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
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
        if(Session::get('login') && (Session('type') == 4)){
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
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Session::get('login') && (Session('type') == 1)){
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('product.index')->with('deleted',$id);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }
}
