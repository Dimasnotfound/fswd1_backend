<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerTest extends Controller
{
    public function testApi(Request $request){
        dd('test');
    }
}
