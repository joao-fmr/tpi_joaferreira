<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 24.05.2023
 * Description : Requests Controller that makes API requests to insert data in the database and get data from the database 
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Values;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RequestsController extends Controller
{
    /**
     * Stores new data in the t_values table and clears the cache
     * @param Request $request : Request containing the data to insert
     * @return JsonResponse : json response indicating if the insertion was successfull
     */
    public function store(Request $request)
    {
        // get data from input request
        $data = [
            'valWindSpeed' => $request->input('valWindSpeed'),
            'valWindDirection' => $request->input('valWindDirection'),
            'valGust' => $request->input('valGust'),
            'valEntryDate' => $request->input('valEntryDate'),
            'valStoredDate' => $request->input('valStoredDate'),
            'fkStation' => $request->input('fkStation')
        ];

        // insert data into t_values table
        Values::create($data);

        // return success response
        return response()->json(['message' => 'Data successfully stored...'], 201);
    }

    /**
     * Gets all data from the t_station table
     * @param Request $request : Request containing the input data from the URL
     * @return JsonResponse : JSON response containing the data from the t_station table
     */
    public function getStations(Request $request)
    {
        // get the station ID from URL input (?idStation=), null by default 
        $idStation = $request->query('idStation', null);
    
        // generate a cache key based on the idStation parameter
        $cacheKey = $idStation ? 'station_'.$idStation : 'stations';
    
        // retrieve data from cache or store it in cache if it doesn't exist
        $data = Cache::remember($cacheKey, 86400, function () use ($idStation) {
            if ($idStation) {
                // retrieve station with the specified ID
                return Station::where('idStation', $idStation)->first();
            } else {
                // retrieve all stations
                return Station::all();
            }
        });
    
        // return data as JSON response
        return response()->json($data);
    }
}

