<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index(){
        $shops = Shop::with(['area', 'genre'])->get();

        return view('index', compact('shops'));
    }

    public function detail(){
        return view('detail');
    }

    public function done(){
        return view('done');
    }
}
