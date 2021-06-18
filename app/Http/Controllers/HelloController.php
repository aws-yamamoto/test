<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelloController extends Controller
{
    public function getHello()
    {
        return 'getHello';
    }

    public function postHello()
    {
        return 'postHello';
    }

    public function postLbb(Request $request)
    {
        return $request;
    }
}
