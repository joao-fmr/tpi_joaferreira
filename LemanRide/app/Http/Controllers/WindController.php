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
        $starImg = '<svg aria-hidden="true" class="xs:w-8 lg:w-16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>';
        $dangerImg = "<div class ='strength-danger mt-2 flex justify-center'> <img class='danger w-3/10 lg:w-3/10' src='" . asset('img/danger.png ') . "' alt='Signe de danger qu'il ne faut pas aller dans le lac Léman'></div>";

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
            $stars = "Le lac est sûr !";           
        }

        return $stars;
    }

    // remplacer valWindSpeed et valGust par average dans la méthode getValues de l'API
    private function calculateKnots2($data)
    {
        $windStrength = round($data['valWindSpeed'] * self::CONVERT_KNOTS, 2);
        $gustStrength = round($data['valGust'] * self::CONVERT_KNOTS, 2);


        $averageStrength = round(($windStrength + $gustStrength) / 2, 2);
        return ['windStrength' => $windStrength, 'gustStrength' => $gustStrength, 'averageStrength' => $averageStrength];
    }


    private function separateValues($allData)
    {
        $result = [];
        foreach($allData as $data) {
            $knots = $this->calculateKnots2($data);
            $result[] = [
                'windStrength' => $knots['windStrength'],
                'gustStrength' => $knots['gustStrength'],
                'averageStrength' => $knots['averageStrength'],
                'valStoredDate' => $data['valStoredDate']
            ];
        }
        return $result;
    }

    public function renderIndex()
    {
        $data = $this->apiService->getLatestValuesData(true);

        $allData = $this->apiService->getValuesData(96, $average = true);
        
        $graphData = $this->separateValues($allData);

        $direction = $this->compassDirection($data);
        $data['compass'] = $direction['compass'];
        $data['name'] = $direction['name'];

        $strengths = $this->calculateKnots($data);
        $data['windStrength'] = $strengths['windStrength'];
        $data['gustStrength'] = $strengths['gustStrength'];

        $data['strengthStars'] = $this->strengthStars($strengths['averageStrength']);
        return view('home', [
                                'data' => $data,
                                'graphData' => $graphData
                            ]);

    }


    public function renderStations()
    {
        $data = $this->apiService->getStationsData();
        return view('stations', [
                                    'data' => $data
                                ]);
    }


    public function renderAbout()
    {
        return view('about');
    }


    public function renderContact()
    {
        return view('contact');
    }
}
