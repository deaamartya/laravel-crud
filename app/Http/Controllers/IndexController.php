<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Redirect,Response;
use DB;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
      return view('index1');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Session::get('login') && (Session('type') == 4)){
            $category = Category::find($id);
            return view('/cat/edit', ['category' => $category]);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if(Session::get('login') && (Session('type') == 4)){
            $request->validate(['category_name' => 'required']);
            $category = Category::find($id);
            $category->category_name = e($request->input('category_name'));
            $category->save();
            return redirect()->route('categories.index')->with('edited',$id);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    public function destroy($id){

        if(Session::get('login') && (Session('type') == 1)){
            $category = Category::find($id);
            $cat_name = $category->category_name;
            $category->delete();
            return redirect()->route('categories.index')->with('deleted',$cat_name);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    public function updateStatus($id){
        if(Session::get('login') && (Session('type') == 1)){
            $category = Category::find($id);
            if($category->status == 1){
                $category->status = 0;
                $name = $category->category_name;
                $html = '<span class="badge badge-secondary">Nonaktif</span>';
                $label = 'Aktifkan';
            }
            elseif($category->status == 0){
                $category->status = 1;
                $name = $category->category_name;
                $html = '<span class="badge badge-success">Aktif</span>';
                $label = 'Nonaktifkan';
            }
            $category->save();
            return response()->json(['success' => true,'name' => $name,'html' =>$html,'label' => $label,'id' => $id]);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }
}
