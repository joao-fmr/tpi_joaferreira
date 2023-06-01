<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 30.05.2023
 * Description : Wind Controller that handles requests related to wind data 
 * and renders pages
 */


namespace App\Http\Controllers;

use App\Services\WindApiService;
use Illuminate\Http\Request;

class WindController extends Controller
{
    // wind api service instance
    protected $apiService;

    // conversion rate used to convert (km/h) to knots
    private const CONVERT_KNOTS = 0.539957;

    // constant associative array that contains every wind direction and its corresponding name and image name
    private const WIND_DIRECTIONS_ARRAY = [
        ['image' => 'n.png', 'name' => 'Bise'],         // index 1 : 0° - 44° : north 
        ['image' => 'ne.png', 'name' => 'Bise'],        // index 2 : 45° - 89° : north east
        ['image' => 'e.png', 'name' => 'Est'],          // index 3 : 90° - 134° : east
        ['image' => 'se.png', 'name' => 'Sud-Est'],     // index 4 : 135° - 179° : south east
        ['image' => 's.png', 'name' => 'Sud'],          // index 5 : 180° - 224° : south
        ['image' => 'sw.png', 'name' => 'Sud-Ouest'],   // index 6 : 225° - 269° : south weast
        ['image' => 'w.png', 'name' => 'Ouest'],        // index 7 : 270° - 314° west
        ['image' => 'nw.png', 'name' => 'Nord-Ouest']   // index 8 : 315° - 359° : north west
    ];

    // divisor used to calculate the index of the wind direction array
    private const WIND_DIRECTION_DIVISOR = 45; // 360° / 45 = 8 (index)

    // number of decimal places that will be round to
    private const DECIMAL_PLACES_ROUND = 2;

    // the strength values to determine the number of stars to display
    private const STRENGTH_MIN = 10;
    private const STRENGTH_LOW = 12;
    private const STRENGTH_MEDIUM = 15;
    private const STRENGTH_HIGH = 25;

    // the star icone used to display the stars
    private const STRENGTH_STAR_CLASS = '<svg aria-hidden="true" class="xs:w-8 lg:w-16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>';

    // the danger class containing the danger image used to display the danger
    private const STRENGTH_DANGER_CLASS = "<div class ='strength-danger mt-2 flex justify-center'> <img class='danger w-3/10 lg:w-3/10' src='img/danger.png' alt='Signe de danger qu'il ne faut pas aller dans le lac Léman'></div>";
    
    // the number of default hours in the past
    private const LAST_HOURS_DEFAULT = 96;

    /**
     * Creates a new instance of the class
     * 
     * @param WindApiService $apiService : wind api service instance to use
     */
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
        // calculate the index of the array by dividing the value of averageWindDirection by the wind direction divisor and rounding down
        $index = floor($data['averageWindDirection'] / self::WIND_DIRECTION_DIVISOR);

        // retrieve the URL of the corresponding image from the direction image and names constant associative array
        $compass = asset('img/compass/' . self::WIND_DIRECTIONS_ARRAY[$index]['image']);

        // retrieve the name of the corresponding direction from the $directions array
        $name = self::WIND_DIRECTIONS_ARRAY[$index]['name'];
        
        // associative array that contains the keys 'compass' and 'name'
        return ['compass' => $compass, 'name' => $name]; 
    }

    /**
     * Converts the average wind strength to knots with the wind speed strength and the gust strength values   
     *
     * @param array $data : array containing wind data
     * @return array : associative array containing the wind strength, the gust strength, and the average strength of both
     */
    private function convertToKnots($data)
    {
        // calculates the wind and gust strength in knots by converting to knots and rounding it
        $windStrength = round($data['averageWindSpeed'] * self::CONVERT_KNOTS, self::DECIMAL_PLACES_ROUND);
        $gustStrength = round($data['averageGust'] * self::CONVERT_KNOTS, self::DECIMAL_PLACES_ROUND);

        // calculates the average strength of both wind and gust and returns all the results
        $averageStrength = round(($windStrength + $gustStrength) / 2, self::DECIMAL_PLACES_ROUND);
        return ['windStrength' => $windStrength, 'gustStrength' => $gustStrength, 'averageStrength' => $averageStrength];
    }

    /**
     * Determines the number of stars to display based on the value of the average strength
     *
     * @param float $averageStrength : average strength value
     * @return string : string containing the tags with the stars to display
     */
    private function strengthStars($averageStrength)
    {
        // stars tags variable
        $stars = "";
        
        // determines the number of stars to display based on the value of the average strength
        if($averageStrength >= self::STRENGTH_MIN && $averageStrength <= self::STRENGTH_LOW)
        {
            // 1 star
            $stars = "<div class='strength-stars flex justify-center'>" . self::STRENGTH_STAR_CLASS ."</div>";
        }
        elseif($averageStrength > self::STRENGTH_LOW && $averageStrength <= self::STRENGTH_MEDIUM)
        {   
            // 2 stars
            $stars = "<div class='strength-stars flex justify-center'>" . self::STRENGTH_STAR_CLASS . self::STRENGTH_STAR_CLASS ."</div>";
        }
        elseif($averageStrength > self::STRENGTH_MEDIUM && $averageStrength <= self::STRENGTH_HIGH)
        {
            // 3 stars
            $stars = "<div class='strength-stars flex justify-center'>" . self::STRENGTH_STAR_CLASS . self::STRENGTH_STAR_CLASS . self::STRENGTH_STAR_CLASS ."</div>";
        }
        elseif($averageStrength > self::STRENGTH_HIGH)
        {
            // 3 stars and a danger sign
            $stars = "<div class='strength-stars flex justify-center'>" . self::STRENGTH_STAR_CLASS . self::STRENGTH_STAR_CLASS . self::STRENGTH_STAR_CLASS ."</div>" . self::STRENGTH_DANGER_CLASS;
        }
        else
        {
            // no stars
            $stars = "<div class=''><p>Le lac est sûr !</p></div>"; 
        }

        return $stars;
    }

    /**
     * Separates the wind data into an array containing the wind, gust and average strength and the stored data
     * Also converts every strength value to knots.
     *
     * @param float $averageStrength : average strength value
     * @return string : string containing the tags with the stars to display
     */
    private function separateValues($allData)
    {
        // results array
        $result = [];

        // loop through each data value in the array allData
        foreach($allData as $data) {
            // calculates the knots values for the current value
            $knots = $this->convertToKnots($data);

            // add the separated values to the result array
            $result[] = [
                'windStrength' => $knots['windStrength'],
                'gustStrength' => $knots['gustStrength'],
                'averageStrength' => $knots['averageStrength'],
                'valStoredDate' => $data['valStoredDate']
            ];
        }
        
        return $result;
    }

    /**
     * Gets the data for the  home page
     * 
     * @param int|null $lastHours : number of hours in the past to get data for If null, gets data for the last 96 hours
     * @return array : array containing the latest data and the data for the graph
     */
    public function getHomeData($lastHours = null)
    {
        // get the latest values from the API using the services
        $latestData = $this->apiService->getLatestValuesData($average = true);

        // get the data from the API using the services
        $allData = $this->apiService->getValuesData($hours = $lastHours, $average = true);

        // separates the wind data from the API and converts it to knots
        $graphData = $this->separateValues($allData);

        // determines the wind direction for the latest data
        $direction = $this->compassDirection($latestData);
        $latestData['compass'] = $direction['compass'];
        $latestData['name'] = $direction['name'];

        // converts the wind strength and gust strength to knots for the latest data 
        $strengths = $this->convertToKnots($latestData);
        $latestData['windStrength'] = $strengths['windStrength'];
        $latestData['gustStrength'] = $strengths['gustStrength'];

        // determine the number of stars to display for the latest data
        $latestData['strengthStars'] = $this->strengthStars($strengths['averageStrength']);

        // returns the latest data and the data for the graph
        return [
            'latestData' => $latestData,
            'graphData' => $graphData
        ];
    }

    /**
     * Renders the home page with the latest data and the graph data
     * 
     * @return View : home view with the latest data and the graph data 
     */
    public function renderHome()
    {
        // get the data for the home page
        $data = $this->getHomeData();

        // set the number of hours in the past to the default value
        $data['lastHours'] = self::LAST_HOURS_DEFAULT;

        // render the home view with the home data
        return view('home', $data);
    }

    /**
     * Renders the home page with the latest data and graph data for a specific number of hours in the past 
     * 
     * @param Request $request : object containing the user input of the form
     * @return View : home view with the latest data and graph data for a specific number of hours in the past
     */
    public function renderHomeLastHours(Request $request)
    {
        // get the value of the number of last hours from the input of the form
        $lastHours = $request->input('hours');

        // get the data from the home page
        $data = $this->getHomeData($lastHours);

        // sets the number of hours in the past to the value inputed from the form
        $data['lastHours'] = $lastHours;

        // render the home view with the home data
        return view('home', $data);
    }
    

    /**
     * Renders the stations page with station data
     * 
     * @return View : the stations view with station data
     */
    public function renderStations()
    {
        // get station data from the API using a service
        $data = $this->apiService->getStationsData();

        // renders the station view with the station data
        return view('stations', [
                                    'data' => $data
                                ]);
    }

    /**
     * Renders the about view.
     *
     * @return View : the about view
     */
    public function renderAbout()
    {
        return view('about');
    }

    /**
     * Renders the contact view.
     *
     * @return View : the contact view
     */
    public function renderContact()
    {
        return view('contact');
    }
}
