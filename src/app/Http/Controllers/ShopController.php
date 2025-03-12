<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        return view('index');
    }

    public function detail(){
        return view('detail');
    }

    public function done(){
        return view('done');
    }
}
