<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::get('login') && ((Session('type') == 4 || Session('type') == 2) || (Session('type') == 1))){
            $categories = Category::all();
            return view('cat/list', ['categories' => $categories]);
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
            return view('/cat/form');
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
    public function store(Request $request){
        if(Session::get('login') && (Session('type') == 4)){
            $request->validate(['category_name' => 'required']);
            $status = $request->status;

            if($status == "true"){
                $status = 1;
            }
            else{
                $status = 0;
            }
            Category::create(['category_name' => e($request->input('category_name')),
                              'status' => $status
                            ]);
            return redirect()->route('categories.index')->with('inserted',$request->input('category_name'));
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
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
            $cat_name = DB::table('categories')->where('category_id', $id)->value('category_name');
            $category->delete();
            return redirect()->route('categories.index')->with('deleted',$cat_name);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    public function updateStatus($id, Request $request){
        if(Session::get('login') && (Session('type') == 1)){
            $state = Category::find($id,['status']);
            $state = $state["status"];
            $status = $state;
            if($state == "1"){
                $status = 0;
            }
            elseif($state == "0"){
                $status = 1;
            }
            $category = Category::find($id);
            $category->status = $status;
            $category->save();
            return redirect()->route('categories.index')->with('edited',$id);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }
}
