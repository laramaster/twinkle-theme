<?php

namespace  Twinkle\Themes\twinkle\app\http\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class HelloController extends Controller
{
    public function hello()
    {
       return "twinkle";
    }
}
