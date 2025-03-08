<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        return view('index');
    }

    public function detail(){
        return view('detail');
    }

    public function done(){
        return view('done');
    }
}
