<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use App\SaleDetail;
use App\Product;

class SaleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salesdets = DB::table('sales_detail')
                ->join('product', 'product.product_id', '=', 'sales_detail.product_id')
                ->select('sales_detail.nota_id','sales_detail.product_id','product.product_name','sales_detail.quantity','sales_detail.selling_price','sales_detail.discount','sales_detail.total_price')
                ->get();
        return view('saledet/list', ['saledets' => $salesdets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $sales = DB::table('sales')->get();
        $products = DB::table('product')->get();
        return view('sale/cart',['sales' => $sales,'products' => $products]);
    }

    public function createid($id){
        $products = DB::table('product')->get();
        $sales = DB::table('sales')->get();
        $nota_id = $id;
        return view('saledet/formid',['sales' => $sales,'nota_id' => $nota_id,'products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::find($request->input('product_id'));
        $selling_price = $product -> product_price;
        $quantity = $request->input('quantity');
        $discount = $request->input('discount');
        $discount = str_replace("Rp ","",$discount);
        $discount = str_replace(".","",$discount);
        $total_price = ($selling_price*$quantity)-$discount;

        SaleDetail::create([
            'nota_id' => e($request->input('nota_id')),
            'product_id' => e($request->input('product_id')),
            'quantity' => e($request->input('quantity')),
            'selling_price' => $selling_price,
            'discount' => $discount,
            'total_price' => $total_price
        ]);
        return redirect()->route('saledet.index');
    }

    public function insert(Request $request,$id)
    {
        $product = Product::find($request->input('product_id'));
        $selling_price = $product -> product_price;
        $quantity = $request->input('quantity');
        $discount = $request->input('discount');
        $discount = str_replace("Rp ","",$discount);
        $discount = str_replace(".","",$discount);
        $total_price = ($selling_price*$quantity)-$discount;

        SaleDetail::create([
            'nota_id' => $id,
            'product_id' => e($request->input('product_id')),
            'quantity' => e($request->input('quantity')),
            'selling_price' => $selling_price,
            'discount' => $discount,
            'total_price' => $total_price
        ]);
        return redirect()->route('saledet.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleDetail  $saleDetail
     * @return \Illuminate\Http\Response
     */
    public function show(SaleDetail $saleDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SaleDetail  $saleDetail
     * @return \Illuminate\Http\Response
     */
    public function edit($nota_id,$product_id)
    {
        $saledet = SaleDetail::where('nota_id',$nota_id)->where('product_id',$product_id)->first();
        $sales = DB::table('sales')->get();
        $products = DB::table('product')->get();
        return view('saledet.edit',['saledet' => $saledet,'sales' => $sales,'products' => $products,'nota_id' => $nota_id, 'product_id' => $product_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleDetail  $saleDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$nota_id,$product_id)
    {
        $product = Product::find($request->input('product_id'));
        $selling_price = $product -> product_price;
        $quantity = $request->input('quantity');
        $discount = $request->input('discount');
        $discount = str_replace("Rp ","",$discount);
        $discount = str_replace(".","",$discount);
        $total_price = ($selling_price*$quantity)-$discount;

        SaleDetail::where('nota_id',$nota_id)->where('product_id',$product_id)->update([
            'nota_id' => e($request->input('nota_id')),
            'product_id' => e($request->input('product_id')),
            'quantity' => e($request->input('quantity')),
            'selling_price' => $selling_price,
            'discount' => $discount,
            'total_price' => $total_price
        ]);
        return redirect()->route('saledet.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleDetail  $saleDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($nota_id,$product_id)
    {
        SaleDetail::where('nota_id',$nota_id)->where('product_id',$product_id)->delete();
        return redirect()->route('saledet.index');
    }

    
}
