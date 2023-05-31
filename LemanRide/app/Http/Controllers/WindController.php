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

    // conversion rate used to convert (km/h) to knots
    private const CONVERT_KNOTS = 0.539957;

    // constant associative array that contains every wind direction and its corresponding name and image name
    private const WIND_DIRECTIONS_IMAGE = [
        ['image' => 'n.png', 'name' => 'Bise'],
        ['image' => 'ne.png', 'name' => 'Bise'],
        ['image' => 'e.png', 'name' => 'Est'],
        ['image' => 'se.png', 'name' => 'Sud-Est'],
        ['image' => 's.png', 'name' => 'Sud'],
        ['image' => 'sw.png', 'name' => 'Sud-Ouest'],
        ['image' => 'w.png', 'name' => 'Ouest'],
        ['image' => 'nw.png', 'name' => 'Nord-Ouest']
    ];


    public function __construct(WindApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Determines the wind direction based on the value of averageWindDirection
     *
     * @param array $data : array containing wind data
     * @return array : associative array containing 'compass' and 'name' keys
     */
    private function compassDirection($data)
    {
        // calculate the index of the array by dividing the value of averageWindDirection by 45 and rounding down
        $index = floor($data['averageWindDirection'] / 45);

        // retrieve the URL of the corresponding image from the direction image and names constant associative array
        $compass = asset('img/compass/' . self::WIND_DIRECTIONS_IMAGE[$index]['image']);

        // retrieve the name of the corresponding direction from the $directions array
        $name = self::WIND_DIRECTIONS_IMAGE[$index]['name'];
        
        // associative array that contains the keys 'compass' and 'name'
        return ['compass' => $compass, 'name' => $name]; 
    }

    private function calculateKnots($data)
    {
        $wind = round($data['averageWindSpeed'] * self::CONVERT_KNOTS, 2);
        $gust = round($data['averageGust'] * self::CONVERT_KNOTS, 2);

        return ['wind' => $wind, 'gust' => $gust];
    }

    private function strengthStars($wind, $gust)
    {   
        $average = ($wind + $gust) / 2;
        if ($average < 10) {
            $stars = 0;
            $danger= false;
        } elseif ($wind >= 10 && $wind < 12) {
            $stars = 1;
            $danger = false;
        } elseif ($average >= 12 && $wind < 15) {
            $stars = 2;
            $danger = false;
        } elseif ($average >= 15 && $wind < 25) {
            $stars = 3;
            $danger = false;
        } else {
            $stars = 3;
            $danger = true;
        }

        return ['stars' => $stars, 'danger' => $danger];
    }

    public function index()
    {
        $data = $this->apiService->getLatestValuesData(true);

        $direction = $this->compassDirection($data);
        $data['compass'] = $direction['compass'];
        $data['name'] = $direction['name'];

        $strength = $this->calculateKnots($data);
        $data['windStrength'] = $strength['wind'];
        $data['gustStrength'] = $strength['gust'];

        $data['stars'] = $this->strengthStars($data['windStrength'], $data['gustStrength']);

        return view('home')->with('data', $data);
    }
}
