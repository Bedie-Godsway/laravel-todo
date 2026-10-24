<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function hello()
    {
        $name = "World";
        return view('hello', ['name' => $name]);
    }
}
