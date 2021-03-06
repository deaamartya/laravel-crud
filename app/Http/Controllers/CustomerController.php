<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::get('login') && ((Session('type') == 3 || Session('type') == 2) || (Session('type') == 1))){
            $customers = Customer::all();
            $trash = Customer::onlyTrashed()->get();
            return view('cust/list', ['customers' => $customers,'trash' => $trash]);
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
        if(Session::get('login') && (Session('type') == 3)){
            return view('/cust/form');
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    public function getData($id){
        $customer = Customer::find($id);
        return response()->json(['success' => true,'customer' => $customer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['first_name' => 'required',
                            'phone' => 'required',
                            'email' => 'required',
                            'street' => 'required',
                            'city' => 'required',
                            'state' => 'required',
                            'zip_code' => 'required']);
        if(Session::get('login') && (Session('type') == 3)){
        Customer::create([
            'first_name' => e($request->input('first_name')),
            'last_name' => e($request->input('last_name')),
            'phone' => e($request->input('phone')),
            'email' => e($request->input('email')),
            'street' => e($request->input('street')),
            'city' => e($request->input('city')),
            'state' => e($request->input('state')),
            'zip_code' => e($request->input('zip_code')),
        ]);
        return redirect()->route('customer.index')->with('inserted',$request->input('first_name'));
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Session::get('login') && (Session('type') == 3)){
        $customer = Customer::find($id);
        return view('/cust/edit', ['customer' => $customer]);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate(['first_name' => 'required',
                            'phone' => 'required',
                            'email' => 'required',
                            'street' => 'required',
                            'city' => 'required',
                            'state' => 'required',
                            'zip_code' => 'required']);
        if(Session::get('login') && (Session('type') == 3)){
        $customer = Customer::find($id);
        $customer->update([
            'first_name' => e($request->input('first_name')),
            'last_name' => e($request->input('last_name')),
            'phone' => e($request->input('phone')),
            'email' => e($request->input('email')),
            'street' => e($request->input('street')),
            'city' => e($request->input('city')),
            'state' => e($request->input('state')),
            'zip_code' => e($request->input('zip_code'))
        ]);
        return redirect()->route('customer.index')->with('edited',$id);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Session::get('login') && (Session('type') == 1)){
            $customer = Customer::find($id);
            $customer->delete();
            return redirect()->route('customer.index')->with('deleted',$id);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    public function restore($id)
    {
        if(Session::get('login') && (Session('type') == 1)){
            $customer = Customer::onlyTrashed()->find($id);
            $customer->restore();
            return redirect()->route('customer.index')->with('restore',$id);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    public function updateStatus($id){
        if(Session::get('login') && (Session('type') == 1)){
            $customer = Customer::find($id);
            if($customer->status == 1){
                $customer->status = 0;
                $name = $customer->first_name +" "+ $customer->last_name;
                $html = '<span class="badge badge-secondary">Nonaktif</span>';
                $label = 'Aktifkan';
            }
            elseif($customer->status == 0){
                $customer->status = 1;
                $name = $customer->first_name +" "+ $customer->last_name;
                $html = '<span class="badge badge-success">Aktif</span>';
                $label = 'Nonaktifkan';
            }
            $customer->save();
            return response()->json(['success' => true,'name' => $name,'html' =>$html,'label' => $label]);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }
}
