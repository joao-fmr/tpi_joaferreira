<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 30.05.2023
 * Description : Wind Controller  
 */


namespace App\Http\Controllers;

use App\Services\WindApiService;
use Illuminate\Http\Request;

class WindController extends Controller
{
    protected $apiService;

    public function __construct(WindApiService $apiService)
    {
        $this->apiService = $apiService;
    }
    public function index()
    {
        return view('home');
    }
}
