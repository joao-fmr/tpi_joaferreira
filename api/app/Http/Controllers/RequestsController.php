<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 24.05.2023
 * Description : Requests Controller that makes API requests to insert data in the database and get data from the database 
 */

namespace App\Http\Controllers;

use App\Models\Values;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RequestsController extends Controller
{
    /**
     * Stores new data in the t_values table
     * @param Request $request : Request containing the data to insert
     * @return JsonResponse : json response indicating if the insertion was successfull
     */
    public function store(Request $request)
    {
        $data = [
            'valWindSpeed' => $request->input('valWindSpeed'),
            'valWindDirection' => $request->input('valWindDirection'),
            'valGust' => $request->input('valGust'),
            'valEntryDate' => $request->input('valEntryDate'),
            'valStoredDate' => $request->input('valStoredDate'),
            'fkStation' => $request->input('fkStation')
        ];

        Values::create($data);

        return response()->json(['message' => 'Data successfully stored...'], 201);
    }

    /**
     * Retrieves data from the t_station table
     * @return JsonResponse : JSON response containing the data from the t_station table
     */
    public function getStations()
    {
        $stations = Cache::remember('stations', 86400, function () {
            return Station::all();
        });
        return response()->json($stations);
    }

}

