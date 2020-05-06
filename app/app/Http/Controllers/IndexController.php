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
        $years=DB::select("SELECT DISTINCT DATE_FORMAT(`nota_date`,'%Y') as tahun from sales");
        $month=DB::select("SELECT DISTINCT DATE_FORMAT(`nota_date`,'%Y-%M') as bulan from sales ORDER BY DATE_FORMAT(`nota_date`,'%Y-%m')");
        $tahunini = date("Y");
        $bulanini = date("Y-M");
        // $bulanini = "2020-April";
        // dump($bulanini);
        // dump($month);
        // dump($years);
        return view('dashboard',['years' => $years,'month' => $month,'tahunini' => $tahunini,'bulanini' => $bulanini]);
    }

}
