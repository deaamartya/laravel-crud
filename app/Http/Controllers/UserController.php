<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::get('login') && ((Session('type') == 1 || Session('type') == 2))){
        $users = User::all();
        return view('user/list', ['users' => $users]);
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
        if(Session::get('login') && (Session('type') == 1)){
            $job_type = DB::table('job_type')->get();
            return view('/user/form',['job_type' => $job_type]);
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
        $request->validate([
            'first_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required',
            'job_status' => 'required']);
        if(Session::get('login') && (Session('type') == 1)){
        User::create([
            'first_name' => e($request->input('first_name')),
            'last_name' => e($request->input('last_name')),
            'phone' => e($request->input('phone')),
            'email' => e($request->input('email')),
            'password' => $request->password,
            'job_status' => e($request->input('job_status'))
        ]);
        return redirect()->route('user.index')->with('inserted',$request->input('first_name'));
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Session::get('login') && (Session('type') == 1)){
            $user = User::find($id);
            $job_type = DB::table('job_type')->get();
            return view('/user/edit', ['user' => $user,'job_type' => $job_type]);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'first_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required',
            'job_status' => 'required']);
        if(Session::get('login') && (Session('type') == 1)){
        $user = User::find($id);
        $user->update([
            'first_name' => e($request->input('first_name')),
            'last_name' => e($request->input('last_name')),
            'phone' => e($request->input('phone')),
            'email' => e($request->input('email')),
            'password' => e($request->input('password')),
            'job_status' => e($request->input('job_status'))
        ]);
        return redirect()->route('user.index')->with('edited',$id);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Session::get('login') && (Session('type') == 1)){
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index')->with('deleted',$id);
        }
        else{
            return redirect('/')->with('alert','Anda tidak memiliki akses ke halaman');
        }
    }

    public function verify(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $email = $request->email;
        $password = $request->password;

        $data = User::where('email',$email)->first();
        if($data){
            if($data->password == $password){
                Session::put('name',$data->first_name);
                Session::put('last_name',$data->last_name);
                Session::put('user_id',$data->user_id);
                Session::put('email',$data->email);
                Session::put('type',$data->job_status);
                Session::put('login',TRUE);
                return redirect('home');
            }
            else{
                return redirect('login')->with('alert','Password salah!');
            }
        }
        else{
            return redirect('login')->with('alert','Email tidak ditemukan!');
        } 
    }

    public function login(){
        if (!Session::get('login')) {
            return view('login');
        }
        else{
            return redirect('/home')->with('alert','Kamu kan udah login:)');
        }
    }

    public function logout(){
        if (Session::get('login')) {
            $name = Session::get('name');
            Session::flush();
            return redirect('login')->with('logout',$name);
        }
        else{
            return redirect('login')->with('alert','Kamu kan belum login:)');
        }
    }
}
