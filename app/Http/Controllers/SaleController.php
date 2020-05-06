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
use PDF;

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
                ->paginate(10);
                $i=0;
            foreach($sales as $s) {
                $sales[$i]["detail"] = SaleDetail::where('nota_id',$s->nota_id)
                ->select('sales_detail.*','product.product_name')
                ->join('product','product.product_id','=','sales_detail.product_id')
                ->get();
                $i++;
            }
            return view('sale/list', ['sales' => $sales]);
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
        if(Session::get('login') && (Session('type') == 3)){

            $saledetails = $request->session()->get('saledetails');
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
            if(Session::get('sale')){
                $oldsale = Session::get('sale');
                if($request->nota_date != null || $request->customer_id != null){
                    if($request->nota_date != null){ $sale->nota_date = $oldsale->nota_date; }
                    if($request->customer_id != null){ $sale->customer_id = $oldsale->customer_id; }
                }
            }

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

                // dump($sale);
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
            if($request->nota_date != null){ $replace_sale->nota_date = $request->nota_date; }
            if($request->customer_id != null){ $replace_sale->customer_id = $request->customer_id; }
            $replace_sale->user_id = $sale->user_id;
            $replace_sale->total_payment = $sale->total_payment;
            $request->session()->forget('sale');
            $request->session()->put('sale',$replace_sale);
        }
        $product = Product::select('product.*','categories.category_name')
                    ->join('categories','product.category_id','=','categories.category_id')
                    ->get();
        $categories = Category::all();
        
        // dump($sale);
        return view('/sale/cartedit',['saledetails' => $saledetails,'sale' => $sale,'product' => $product,'categories'=>$categories]);
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
                        'total_payment' => 'required',
                        'user_id' => 'required']);
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

    public function getEarnings($tahun){
        if(Session::get('login')){
            $labels=DB::select("CALL getMonths()");
            for($i=0;$i<count($labels);$i++){
                $total=DB::select("SELECT getEarning('".$labels[$i]->namabulan."','".$tahun."') AS hasil");
                // dump($total[0]->hasil);
                $earning[$i]= $total[0]->hasil;
                if($total[0]->hasil ==null){
                    $earning[$i]=0;
                }
            }
            $earning = array_slice($earning, 0,count($labels));
            return response()->json(['earning' => $earning, 'labels' => $labels]);
        }
    }

    public function getEarningBulan($month){
        if(Session::get('login')){
            $tahun = substr($month,0,4);
            $bulan = substr($month,5,10);
            $total=DB::select("SELECT getEarning('".$bulan."','".$tahun."') AS hasil");
            $earning= $total[0]->hasil;
            if($total[0]->hasil < 1){
                $earning[$i]=0;
            }
            return response()->json(['earning' => $earning]);
        }
    }

    public function getTopSell(){
        if(Session::get('login')){
            $top_cat=DB::select("CALL getTopSales()");
            return response()->json(['top_cat' => $top_cat]);
        }
    }

    public function getInfoSale(){
        if(Session::get('login')){
            $monthsale=DB::select("SELECT penjualanBulanIni() AS total");
            $yearsale=DB::select("SELECT penjualanTahunIni() AS total");
            $productsale=DB::select("SELECT totalProdukTerjual() AS total");
            $monproductsale=DB::select("SELECT totalProdukTerjualBulanIni() AS total");
            $sale=DB::select("SELECT totalPenjualan() AS total");
            return response()->json(['monproductsale' => $monproductsale,'monthsale' => $monthsale,'yearsale' => $yearsale,'productsale' => $productsale,'sale' => $sale]);
        }
    }

    public function printPDF(){
        $sales = Sale::orderBy('nota_date')->get();
        return view('pdf_view',['sales' => $sales]);
        // $pdf = PDF::loadView('pdf_view', ['sales' => $sales]);  
        // return $pdf->stream();
    }
    
}
