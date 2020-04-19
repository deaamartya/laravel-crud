<?php

namespace App\Http\Controllers;

use App\Sale;
use App\User;
use App\Customer;
use App\Product;
use App\SaleDetail;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
        if(Session::get('login') && ((Session('type') == 3 || Session('type') == 2) || (Session('type') == 1))){
            $sales = Sale::select(DB::raw('CONCAT(customer.first_name," ",COALESCE(customer.last_name, "")) AS c_fullname'),(DB::raw('CONCAT(user.first_name," ",user.last_name) AS u_fullname')),'sales.*')
                ->join('customer', 'customer.customer_id', '=', 'sales.customer_id')
                ->join('user', 'user.user_id', '=', 'sales.user_id')
                ->paginate(5);
                $i=0;
            foreach($sales as $s) {
                $sales[$i]["detail"] = SaleDetail::where('nota_id',$s->nota_id)
                ->select('sales_detail.*','product.product_name')
                ->join('product','product.product_id','=','sales_detail.product_id')
                ->get();
                $i++;
            }

            $trash = Sale::onlyTrashed()
                ->select(DB::raw('CONCAT(customer.first_name," ",COALESCE(customer.last_name, "")) AS c_fullname'),(DB::raw('CONCAT(user.first_name," ",user.last_name) AS u_fullname')),'sales.*')
                ->join('customer', 'customer.customer_id', '=', 'sales.customer_id')
                ->join('user', 'user.user_id', '=', 'sales.user_id')
                ->get();
            // dump($sales);
            return view('sale/list', ['sales' => $sales,'trash'=> $trash]);
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
    public function create(Request $request)
    {
        // if(Session::get('login') && (Session('type') == 3)){
        // $user = User::all();
        // $customer = Customer::all();
        // $product = Product::all();
        // $nota_id = (DB::table('sales')->max('nota_id'))+1;
        // return view('/sale/cart2',['users' => $user, 'customers' => $customer,'product' => $product,'nota_id' => $nota_id]);
        // }
        // else{
        //     return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        // }

        if(Session::get('login') && (Session('type') == 3)){
            $saledetails = $request->session()->get('saledetails');
            // if($request->session()->has('saledetails')){
            //     $saledetails = $request->session()->get('saledetails');
            //     $s = $request->session()->get('saledetails');
            //     foreach ($s as $key) {
                    
            //     }

            //     $product = Product::select('product.*','categories.category_name')
            //     ->join('categories','product.category_id','=','categories.category_id')
            //     ->get();
            //     $categories = Category::all();
            //     $nota_id = $request->session()->get('nota_id');
            //     return view('sale/edit1',compact('saledetails', $saledetails),['product' => $product,'categories' => $categories,'nota_id' => $nota_id]);
            // }
            // else{
                $product = Product::select('product.*','categories.category_name')
                    ->join('categories','product.category_id','=','categories.category_id')
                    ->get();
                $categories = Category::all();

                $max = DB::table('sales')->max('nota_id');
                date_default_timezone_set('Asia/Jakarta');
                $date = date("ymd", time());
                $maxday = substr($max,0,6);
                $max = substr($max,6);

                if($maxday == $date){
                    $nota_id = $date.str_pad($max+1,4,"0",STR_PAD_LEFT);
                }

                else{
                    $nota_id = $date.str_pad(1,4,"0",STR_PAD_LEFT);
                }

                $user_id = Session::get('user_id');

                return view('/sale/cart',compact('saledetails'),['product' => $product,'nota_id' => $nota_id,'user_id'=>$user_id,'categories'=>$categories]);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    public function storeStep1(Request $request){
        if(Session::get('login') && (Session('type') == 3)){
            
                $sale = new Sale;
                $sale->user_id = $request->user_id;
                $sale->nota_id = $request->nota_id;
                $sale->status = 1;
                $sale->total_payment = $request->total_payment;

                $saledetails;
                foreach($request->product_id as $key){
                    $detailorder = new SaleDetail;
                    $detailorder->nota_id = $request['nota_id'];
                    $detailorder->product_id = $key;
                    $detailorder->quantity = $request['jumlah'][$key];
                    $detailorder->selling_price = $request['selling_price'][$key];
                    $detailorder->discount = $request['discount'][$key];
                    $detailorder->total_price = $request['total'][$key];
                    $detailorder->status=1;
                    $saledetails[$key] = $detailorder;

                    $detailproduk = Product::find($key);
                    $saledetails[$key]["product_name"] = $detailproduk->product_name;
                }

            $request->session()->forget('saledetails');
            $request->session()->forget('sale');
            $request->session()->put('saledetails', $saledetails);
            $request->session()->put('sale', $sale);

                // dump($saledetails);
                // $request->session()->put('nota_id',$request->nota_id);
            
            // $nota_id = (DB::table('sales')->max('nota_id'))+1;
            
            return redirect('sale/create/step2');
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    public function createStep2(Request $request){
        $saledetails = $request->session()->get('saledetails');
        $sale = $request->session()->get('sale');
        $customer = Customer::all();
        // dump($saledetails);
        // dump($sale);
        return view('/sale/step2',['saledetails' => $saledetails,'sale' => $sale,'customer'=>$customer]);
    }

    public function editStep1(Request $request){
        $saledetails = $request->session()->get('saledetails');
        $sale = $request->session()->get('sale');
        if($request->nota_date != null || $request->customer_id != null){
            $request->session()->forget('sale');
            if($request->nota_date != null){ $sale->nota_date = $request->nota_date; }
            if($request->customer_id != null){ $sale->customer_id = $request->customer_id; }
            $request->session()->put('sale',$sale);
        }
        $product = Product::select('product.*','categories.category_name')
                    ->join('categories','product.category_id','=','categories.category_id')
                    ->get();
        $categories = Category::all();
        $nota_id = (DB::table('sales')->max('nota_id'))+1;
        return view('/sale/cartedit',['saledetails' => $saledetails,'sale' => $sale,'product' => $product,'nota_id' => $nota_id,'categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate(['customer_id' => 'required',
                        'nota_date' => 'required',
                        'total_payment' => 'required']);
        if(Session::get('login') && (Session('type') == 3)){
            DB::transaction(function() use ($request){
                
                Sale::create([
                    'nota_id' => $request->nota_id,
                    'customer_id' => $request->input('customer_id'),
                    'user_id' => $request->user_id,
                    'nota_date' => $request->nota_date,
                    'total_payment' => $request->total_payment,
                    'status' => 1
                ]);
                foreach ($request['product_id'] as $key) {
                    $detailorder = new SaleDetail;
                    $detailorder->nota_id = $request['nota_id'];
                    $detailorder->product_id = $key;
                    $detailorder->quantity = $request['jumlah'][$key];
                    $detailorder->selling_price = $request['selling_price'][$key];
                    $detailorder->discount = $request['discount'][$key];
                    $detailorder->total_price = $request['total'][$key];
                    $detailorder->status=1;
                    $detailorder->save();
                }

            });

            return redirect()->route('sale.index')->with('inserted',$request->input('nota_id'));
            
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        if(Session::get('login')  && ((Session('type') == 3 || Session('type') == 2) || (Session('type') == 1)) ){
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
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Session::get('login') && (Session('type') == 3)){
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
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $input,$id){
        $input->validate(['customer_id' => 'required',
            'nota_id' => 'required',
            'customer_id' => 'required',
            'user_id' => 'required',
            'nota_date' => 'required',
            'total_payment' => 'required']);
        if(Session::get('login') && (Session('type') == 3)){
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
        return redirect()->route('sale.index')->with('edited',$id);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if(Session::get('login') && (Session('type') == 1)){
            $detailorder = SaleDetail::where('nota_id','=',$id)->delete();

            $sale = Sale::where('nota_id','=',$id)->first();
            $sale->delete();
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    public function restore($id){
        if(Session::get('login') && (Session('type') == 1)){
            $detailorder = SaleDetail::where('nota_id','=',$id)->restore();
            $sale = Sale::where('nota_id','=',$id)->restore();
        return redirect()->route('sale.index')->with('restored',$id);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }
}
