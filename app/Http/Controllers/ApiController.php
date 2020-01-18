<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;

class ApiController extends Controller
{
    //
    public function getProducts(){
        $products = Products::get();
        return response()->json([
            'product'=>$products
        ]);
    }
    public function getProducts1(Request $req){
        $products = Products::where('id',$req->id)->first();
        return response()->json([
            'product'=>$products
        ]);
    }
    
}
