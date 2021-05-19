<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Stmt\If_;

class ProductController extends Controller
{

    public function index(){

        return view('products');

    }

    public function search(){

        $busca = request('search');
        if(isset($busca)){

            return view('products', ['busca' => $busca]);
        }
    }
}
