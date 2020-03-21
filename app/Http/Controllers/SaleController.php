<?php

namespace App\Http\Controllers;

use App\Sale;
use App\User;
use App\Customer;
use App\Product;
use App\SaleDetail;
use Illuminate\Http\Request;
use DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::select(DB::raw('CONCAT(customer.first_name," ",customer.last_name) AS c_fullname'),(DB::raw('CONCAT(user.first_name," ",user.last_name) AS u_fullname')),'sales.nota_id','sales.nota_date','sales.total_payment')
            ->join('customer', 'customer.customer_id', '=', 'sales.customer_id')
            ->join('user', 'user.user_id', '=', 'sales.user_id')
            ->get();
        // return view('sale/list', ['sales' => $sales]);
        return view('sale/list', ['sales' => $sales]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        $customer = Customer::all();
        $product = Product::all();
        $nota_id = (DB::table('sales')->max('nota_id'))+1;
        return view('/sale/cart2',['users' => $user, 'customers' => $customer,'product' => $product,'nota_id' => $nota_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $input){

        $input->validate(['customer_id' => 'required',
            'nota_id' => 'required',
            'customer_id' => 'required',
            'user_id' => 'required',
            'nota_date' => 'required',
            'total_payment' => 'required']);
        Sale::create([
            'nota_id' => e($input->input('nota_id')),
            'customer_id' => e($input->input('customer_id')),
            'user_id' => e($input->input('user_id')),
            'nota_date' => e($input->input('nota_date')),
            'total_payment' => e($input->input('total_payment'))
        ]);
        foreach ($input['product_id'] as $key) {
            $detailorder = new SaleDetail;
            $detailorder->nota_id = $input['nota_id'];
            $detailorder->product_id = $key;
            $detailorder->quantity = $input['jumlah'][$key];
            $detailorder->selling_price = $input['selling_price'][$key];
            $detailorder->discount = $input['discount'][$key];
            $detailorder->total_price = $input['total'][$key];
            $detailorder->save();
        }
        return redirect()->route('sale.index')->with('inserted',$request->input('nota_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $sale = Sale::where('nota_id','=',$id)
            ->select(DB::raw('CONCAT(customer.first_name," ",customer.last_name) AS c_name'),DB::raw('CONCAT(user.`first_name`," ",`user`.`last_name`) AS u_name'),'customer.street',DB::raw('CONCAT(customer.city,", ",customer.state," ",customer.zip_code) AS c_address'),'customer.phone','customer.email','user.phone AS u_phone','user.email AS u_email','nota_date','nota_id','total_payment')
            ->join('customer', 'customer.customer_id', '=', 'sales.customer_id')
            ->join('user', 'user.user_id', '=', 'sales.user_id')
            ->first();
        $saledetail = SaleDetail::where('nota_id','=',$id)
            ->select('sales_detail.nota_id','sales_detail.product_id', 'product.product_name','sales_detail.quantity', 'sales_detail.selling_price', 'sales_detail.discount','sales_detail.total_price')
            ->join('product', 'sales_detail.product_id', '=', 'product.product_id')
            ->get();
        return view('sale/show',['sale' => $sale, 'saledetail' => $saledetail]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = Sale::where('nota_id','=',$id)->first();
        $user = User::all();
        $customer = Customer::all();
        $product = Product::all();
        $saledetail = SaleDetail::where('nota_id','=',$id)
            ->select('sales_detail.nota_id','sales_detail.product_id', 'product.product_name','sales_detail.quantity', 'sales_detail.selling_price','sales_detail.discount','sales_detail.total_price','product.product_stock')
            ->join('product', 'sales_detail.product_id', '=', 'product.product_id')
            ->get();
        return view('/sale/edit2',['users' => $user, 'customers' => $customer,'product' => $product,'sale' => $sale, 'detailorder' => $saledetail]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $input,$id){
        Sale::where('nota_id','=',$id)->update([
            'nota_id' => $input->input('nota_id'),
            'customer_id' => $input->input('customer_id'),
            'user_id' => $input->input('user_id'),
            'nota_date' => $input->input('nota_date'),
            'total_payment' => $input->input('total_payment')
        ]);
        SaleDetail::where('nota_id','=',$id)->delete();
        foreach ($input['product_id'] as $key){
            DB::table('sales_detail')->updateOrInsert(
                ['nota_id' => $input->input('nota_id'), 'product_id' => $key],
                ['quantity' => $input['jumlah'][$key],
                'selling_price' => $input['selling_price'][$key],
                'discount' => $input['discount'][$key],
                'total_price' => $input['total'][$key]
            ]);
        }
        return redirect()->route('sale.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detailorder = SaleDetail::where('nota_id','=',$id)->delete();
        $sale = Sale::where('nota_id','=',$id)->first();
        $sale->delete();
        return redirect()->route('sale.index');
    }
}
