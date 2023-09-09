<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyNewController extends Controller
{
    public function index(){
        return "this is index";
    }

    public function report(){
        return "report page";
    }
}
