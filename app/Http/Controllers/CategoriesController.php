<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;

class CategoriesController extends Controller
{

    public function __construct(){

    }

    public function index(){
        return view('admin/categories/index');
    }
}
