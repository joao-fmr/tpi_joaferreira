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
        ['image' => 'n.png', 'name' => 'Bise'],         // 0° - 44° : north 
        ['image' => 'ne.png', 'name' => 'Bise'],        // 45° - 89° : north east
        ['image' => 'e.png', 'name' => 'Est'],          // 90° - 134° : east
        ['image' => 'se.png', 'name' => 'Sud-Est'],     // 135° - 179° : south east
        ['image' => 's.png', 'name' => 'Sud'],          // 180° - 224° : south
        ['image' => 'sw.png', 'name' => 'Sud-Ouest'],   // 225° - 269° : south weast
        ['image' => 'w.png', 'name' => 'Ouest'],        // 270° - 314° west
        ['image' => 'nw.png', 'name' => 'Nord-Ouest']   // 315° - 359° : north west
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

    /**
     * Calculates the average wind strength in knots with the wind speed strength and the gust strength values   
     *
     * @param array $data : array containing wind data
     * @return array : associative array containing the wind strength, the gust strength, and the average strength of both
     */
    private function calculateKnots($data)
    {
        $windStrength = round($data['averageWindSpeed'] * self::CONVERT_KNOTS, 2);
        $gustStrength = round($data['averageGust'] * self::CONVERT_KNOTS, 2);


        $averageStrength = round(($windStrength + $gustStrength) / 2, 2);
        return ['windStrength' => $windStrength, 'gustStrength' => $gustStrength, 'averageStrength' => $averageStrength];
    }


    private function strengthStars($averageStrength)
    {
        $stars = "";
        $starImg = "<img class='w-10 lg:w-20' src='" . asset('img/star.png ') . "' alt='Étoile indiquant le niveau de danger sur le lac Léman'>";
        $dangerImg = "<div class ='strength-danger mt-2 flex justify-center'> <img class='w-10 lg:w-20' src='" . asset('img/danger.png ') . "' alt='Signe de danger qu'il ne faut pas aller dans le lac Léman'></div>";

        if($averageStrength >= 10 && $averageStrength <= 12)
        {
            $stars = "<div class='strength-stars flex justify-center'>" . $starImg ."</div>";
        }
        elseif($averageStrength > 12 && $averageStrength <= 15)
        {   
            $stars = "<div class='strength-stars flex justify-center'>" . $starImg . $starImg ."</div>";
        }
        elseif($averageStrength > 15 && $averageStrength <= 25)
        {
            $stars = "<div class='strength-stars flex justify-center'>" . $starImg . $starImg . $starImg ."</div>";
        }
        elseif($averageStrength > 25)
        {
            $stars = "<div class='strength-stars flex justify-center'>" . $starImg . $starImg . $starImg ."</div>" . $dangerImg;
        }
        else
        {
            //$stars = "Le lac est sûr !";
            $stars = "<div class='strength-stars flex justify-center'>" . $starImg . $starImg . $starImg ."</div>" . $dangerImg;
           
        }

        return $stars;
    }


    public function index()
    {
        $data = $this->apiService->getLatestValuesData(true);

        $direction = $this->compassDirection($data);
        $data['compass'] = $direction['compass'];
        $data['name'] = $direction['name'];

        $strengths = $this->calculateKnots($data);
        $data['windStrength'] = $strengths['windStrength'];
        $data['gustStrength'] = $strengths['gustStrength'];

        $data['strengthStars'] = $this->strengthStars($strengths['averageStrength']);
        return view('home')->with('data', $data);
    }
}
