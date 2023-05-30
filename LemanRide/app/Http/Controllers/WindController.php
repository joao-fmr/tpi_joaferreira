<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;

class WindController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
