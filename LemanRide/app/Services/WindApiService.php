<?php 
/**
 * ETML
 * Author : João Ferreira
 * Date : 30.05.2023
 * Description : Wind API Service that retrieves data from the API URL requests
 */

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WindApiService
{
    // api base URL
    private const API_BASE_URL = "http://lemanride.section-inf.ch/api/public/";

    /**
     * Get data for stations from the API
     * @param int|null $idStation : ID of the station to get data for. If null, data for all stations is returned.
     * @return array : data returned from the API
    */
    public function getStationsData($idStation = null)
    {
        // set the URL for the API request based on the based URL
        $url = self::API_BASE_URL . "stations";

        // if ID of a station is given, add it to the url
        $url .= $idStation ? "&idStation=$idStation" : '';

        // send a GET request to the API and return the response
        $response = Http::get($url);
        return $response->json();
    }
    
    /**
     * Get values data from the API
     * @param int|null $hours : number of hours to get data for. If null, data for the last 96 hours is returned.
     * @param string|null $average : type of average to apply to the data. If null, no average is applied.
     * @return array : data returned from the API
    */
    public function getValuesData($hours = null, $average = null)
    {
        // set the base URL for the API request
        $url = self::API_BASE_URL . "values";

        // initialize an array to hold the query parameters
        $queryParams = [];

        // if hours is not null, add it to the query parameters
        if ($hours) {
            $queryParams['hours'] = $hours;
        }

        // if average is not null, add it to the query parameters
        if ($average) {
            $queryParams['average'] = $average;
        }

        // build the query string from the query parameters
        $queryString = http_build_query($queryParams);

        // append the query string to the url
        $url .= '?' . $queryString;


        // send a GET request to the API and return the response
        $response = Http::get($url);
        return $response->json();
    }

    /**
     * Get values data of a station and date from the API
     * @param int $idStation : ID of the station to get data for
     * @param int|null $hours : number of hours to get data for. If null, data for all hours is returned.
     * @return array : data returned from the API
    */
    public function getValuesOfStationData($idStation, $hours = null)
    {
        // set the base URL for the API request
        $url = self::API_BASE_URL . "values/$idStation";

        // if hours value is given, add it to the URL
        $url .= $hours ? "?hours=$hours" : '';

        // send a GET request to the API and return the response
        $response = Http::get($url);
        return $response->json();
    }

    /**
     * Get the latest values data from the API
     * @param string|null $average : type of average to apply to the data. If null, no average is applied.
     * @return array : data returned from the API
    */
    public function getLatestValuesData($average = null)
    {
        // set the base URL for the API request
        $url = self::API_BASE_URL . "values/latest";

        // if average value is given, add it to the URL
        $url .= $average ? "?average=$average" : '';

        // send a GET request to the API and return the response
        $response = Http::get($url);
        return $response->json();
    }
}