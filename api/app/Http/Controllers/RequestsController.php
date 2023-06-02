<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 24.05.2023
 * Description : Requests Controller that makes API requests 
 * to insert data in the database and get data from the database 
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Values;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RequestsController extends Controller
{   
    // time that the stations cache will expire
    private const STATIONS_CACHE_TIME = 86400; // 24 hours

    // time that the values cache will expire
    private const VALUES_CACHE_TIME = 300; // 5 minutes

    // carbon timezone to compare it to database datetime
    private const DEFAULT_TIMEZONE = 'Europe/Paris';

    // default number of hours to get data from
    private const DEFAULT_HOURS = 96;

    // default average bool value to determine if we want average values or not
    private const DEFAULT_AVERAGE_BOOL = false;

    // the http code status code for a successful POST request
    private const HTTP_CODE_INSERT = 201;


    /**
     * Stores new data in the t_values table and clears the cache
     * 
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

        // clear the caches
        Cache::flush();

        // return success response
        return response()->json(['message' => 'Data successfully stored...'], self::HTTP_CODE_INSERT);
    }

    /**
     * Gets all data from the t_station table
     * 
     * @param Request $request : Request containing the input data from the URL
     * @return JsonResponse : JSON response containing the data from the t_station table
     */
    public function getStations(Request $request)
    {
        // get the station ID from URL input (?idStation=), null by default 
        $idStation = $request->query('idStation', null);
    
        // generate a cache tag based on the idStation parameter
        $cacheTag = $idStation ? 'station_'.$idStation : 'stations';
    
        // retrieve data from cache or store it in cache if it doesn't exist
        $data = Cache::remember($cacheTag, self::STATIONS_CACHE_TIME, function () use ($idStation) {
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

    
    /**
     * Get all values from the last specified number of hours 
     * (96h by default) and average or not (false by default)
     * 
     * @param Request $request : Request containing the input data from the URL
     * @return JsonResponse : JSON response containing the data
     */
    public function getValues(Request $request)
    {
        // get number of hours from URL input (?hours=) 96 by default 
        $hours = $request->input('hours', self::DEFAULT_HOURS);
        // get average bool from URL input (?average=) false by default
        $average = filter_var($request->input(
                                    'average', 
                                    self::DEFAULT_AVERAGE_BOOL), FILTER_VALIDATE_BOOLEAN
                              );

        // create a cache tag based on the input parameters
        $cacheTag = "values_{$hours}_{$average}";
    
        // retrieve data from cache or store it in cache if it doesn't exist
        $data = Cache::remember($cacheTag, self::VALUES_CACHE_TIME, function () use ($hours, $average) {
            // retrieve all values from the last specified number of hours
            $data = Values::join('t_station', 't_values.fkStation', '=', 't_station.idStation')
                ->where('valStoredDate', '>=',Carbon::now(self::DEFAULT_TIMEZONE)->subHours($hours))
                ->orderBy('valStoredDate', 'desc')
                ->get(['idStation', 
                        'staName', 
                        'valWindSpeed', 
                        'valWindDirection', 
                        'valGust', 
                        'valEntryDate', 
                        'valStoredDate']);
    
            // if the average bool is true
            if ($average) {
                // group the data by stored date and calculate each group's average
                $data = $data->groupBy('valStoredDate');
                $data = $data->map(function ($item) {
                    return [
                        'averageWindSpeed' => round($item->avg('valWindSpeed'), 1),
                        'averageWindDirection' => round($item->avg('valWindDirection')),
                        'averageGust' => round($item->avg('valGust'), 1),
                        'valEntryDate' => $item->first()['valEntryDate'],
                        'valStoredDate' => $item->first()['valStoredDate']
                    ];
                });
            }
    
            return $data;
        });
    
        return response()->json($data);
    }
    
    

    /**
     * Get all values for a specific station from the last specified number of hours
     * 
     * @param int $idStation : ID of the station choosen put in the URL
     * @param Request $request : Request containing the input data from the URL
     * @return JsonResponse : JSON response containing the data
     */
    public function getAllValuesByStation(Request $request, $idStation)
    {
        // get number of hours from URL input (?hours=) 96 by default 
        $hours = $request->input('hours', self::DEFAULT_HOURS);

        // create a cache tag based on the input parameters
        $cacheTag = "values_station_{$idStation}_{$hours}";

        // retrieve all values for the specified station from the last specified number of hours
        $data = Cache::remember($cacheTag, self::VALUES_CACHE_TIME, function () use ($hours, $idStation) {
            $data = Values::join('t_station', 't_values.fkStation', '=', 't_station.idStation')
                ->where('fkStation', $idStation)
                ->where('valStoredDate', '>=', Carbon::now(self::DEFAULT_TIMEZONE)->subHours($hours))
                ->orderBy('valStoredDate', 'desc')
                ->get(['idStation', 
                        'staName', 
                        'valWindSpeed', 
                        'valWindDirection', 
                        'valGust', 
                        'valEntryDate', 
                        'valStoredDate']);
            
            return $data;
        });
        // return data as JSON response
        return response()->json($data);
    }

    /**
     * Get the latest values for each station or average of all stations (false by default)
     * 
     * @param Request $request : Request containing the input data from the URL
     * @return JsonResponse : JSON response containing the data
     */
    public function getLatestValuesEachStation(Request $request)
    {
        // get average bool from URL input (?average=) false by default
        $average = filter_var($request->input('average', self::DEFAULT_AVERAGE_BOOL), FILTER_VALIDATE_BOOLEAN);

        // create a cache tag based on the input parameters
        $cacheTag = "latest_values_each_station_{$average}";

        // retrieve data from cache or store it in cache if it doesn't exist
        $data = Cache::remember($cacheTag, self::VALUES_CACHE_TIME, function () use ($average) {
            // create a subquery to get the maximum stored data (most recent one) for each station
            $subQuery = Values::selectRaw('fkStation, MAX(valStoredDate) as max_date')
                ->groupBy('fkStation');

            // join the subquery with main query to get only the latest values for each station
            $data = Values::join('t_station', 't_values.fkStation', '=', 't_station.idStation')
                ->joinSub($subQuery, 'latest_values', function ($join) {
                    $join->on('t_values.fkStation', '=', 'latest_values.fkStation')
                        ->on('t_values.valStoredDate', '=', 'latest_values.max_date');
                })
                ->get(['idStation', 
                        'staName', 
                        'valWindSpeed', 
                        'valWindDirection', 
                        'valGust', 
                        'valEntryDate', 
                        'valStoredDate']);

            // if the average bool is true
            if ($average) {
                // do the average for each value
                $averageWindSpeed = round($data->avg('valWindSpeed'), 1);
                $averageWindDirection = round($data->avg('valWindDirection'));
                $averageGust = round($data->avg('valGust'), 1);
                
                // get the last stored date
                $valStoredDate = $data->first()->valStoredDate; 

                // return the average values and the stored date
                return [
                    'averageWindSpeed' => $averageWindSpeed,
                    'averageWindDirection' => $averageWindDirection,
                    'averageGust' => $averageGust,
                    'valStoredDate' => $valStoredDate
                ];
            }

            // return the data from the entire query
            return $data;
        });

        // return data as JSON response
        return response()->json($data);
    }
}

