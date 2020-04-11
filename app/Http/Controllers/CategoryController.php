<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Redirect,Response;
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
            if(request()->ajax()) {
              return datatables()->of(Category::all())
                    ->addColumn('status', function($data){
                        if(($data->status) == 0){
                          $status ='<h5 id="badgestatus'.$data->category_id.'">';
                          $status .='<span class="badge badge-secondary">Nonaktif</span></h5>';
                        }
                        else{
                          $status ='<h5 id="badgestatus'.$data->category_id.'">';
                          $status .='<span class="badge badge-success">Aktif</span></h5>';
                        }
                        return $status;
                    })
                    ->rawColumns(['status'])
                    ->make(true);
            }
            else{
              $categories = Category::all();
              $trash = Category::onlyTrashed()->get();
            }
            return view('cat/list',['categories' => $categories,'trash' => $trash]);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    public function getCategory(){
        return datatables()->of(Category::all())
          ->make(true);
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
                $category->save();
                $category->delete();
                $html = '<span class="badge badge-secondary">Nonaktif</span>';
                $label = 'Aktifkan';
            }
            elseif($category->status == 0){
                $category->status = 1;
                $name = $category->category_name;
                $category->save();
                $category->restore();
                $html = '<span class="badge badge-success">Aktif</span>';
                $label = 'Nonaktifkan';
            }
            return response()->json(['success' => true,'category' => $category,'html' =>$html]);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }
}
