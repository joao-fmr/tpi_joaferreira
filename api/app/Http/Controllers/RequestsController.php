<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 24.05.2023
 * Description : Requests Controller that makes requests to insert data in the database and get data from the database 
 */

namespace App\Http\Controllers;

use App\Models\Values;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
    public function store(Request $request)
    {
        $data = [
            'valWindSpeed' => $request->input('valWindSpeed'),
            'valWindDirection' => $request->input('valWindDirection'),
            'valGust' => $request->input('valGust'),
            'valEntryDate' => $request->input('valEntryDate'),
            'valRegisteredDate' => $request->input('valRegisteredDate'),
            'fkStation' => $request->input('fkStation')
        ];

        Values::create($data);

        return response()->json(['message' => 'Données insérées avec succès'], 201);
    }
}

