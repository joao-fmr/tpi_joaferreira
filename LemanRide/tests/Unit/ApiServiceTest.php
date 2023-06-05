<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 02.06.2023
 * Description : Api Service Test class that tests methods of the Api Service
 */

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase; does not work

use Tests\TestCase;

use App\Services\WindApiService;


class ApiServiceTest extends TestCase
{
    // average bool test value
    private const AVERAGE_TEST_BOOL = true;

    // station id test value
    private const ID_STATION_TEST = "PRE";

    // number of hours test value
    private const HOURS_NUMBER_TEST = 24;

    /**
     * Tests the method that gets all stations of the API service
     */
    public function testGetStationsData()
    {
        // creates new api service and gets data from the method
        $service = new WindApiService();
        $data = $service->getStationsData();

        // check that the returned data is an array
        $this->assertIsArray($data);

        // check that the returned data contains data for the value
        $this->assertNotEmpty($data);
    }

    /**
     * Tests the method that gets all values of the API service
     */
    public function testGetValuesData()
    {
        // creates new api service and gets data from the method
        $service = new WindApiService();
        $data = $service->getValuesData();

        // check that the returned data is an array
        $this->assertIsArray($data);

        // check that the returned data contains data for the value
        $this->assertNotEmpty($data);
    }

    /**
     * Tests the method that gets all values with the hours parameter of the API service
     */
    public function testGetValuesDataWithHours()
    {
        // creates new api service and gets data from the method with the hours parameter
        $service = new WindApiService();
        $data = $service->getValuesData($hours = self::HOURS_NUMBER_TEST);

        // check that the returned data is an array
        $this->assertIsArray($data);

        // check that the returned data contains data for the value
        $this->assertNotEmpty($data);
    }   

     /**
     * Tests the method that gets all values of a station
     */
    public function testGetValuesOfStationDate()
    {
        // creates new api service and gets data from the method with a test ID
        $service = new WindApiService();
        $data = $service->getValuesOfStationData($idStation = self::ID_STATION_TEST);

        // check that the returned data is an array
        $this->assertIsArray($data);

        // check that the returned data contains data for the value
        $this->assertNotEmpty($data);
    }

    /**
     * Tests the method that gets all values of a station with the hours parameter
     */
    public function testGetValuesByStationDateWithHours()
    {
        // creates new api service and gets data from the method with the test ID and the hours parameter
        $service = new WindApiService();
        $data = $service->getValuesOfStationData($idStation = self::ID_STATION_TEST, $hours = self::HOURS_NUMBER_TEST);

        // check that the returned data is an array
        $this->assertIsArray($data);

        // check that the returned data contains data for the value
        $this->assertNotEmpty($data);
    }

    /**
     * Tests the method that gets the latest values
     */
    public function testGetLatestValuesData()
    {
        // creates new api service and gets data from the method
        $service = new WindApiService();
        $data = $service->getLatestValuesData();

        // check that the returned data is an array
        $this->assertIsArray($data);

        // check that the returned data contains data for the value
        $this->assertNotEmpty($data);
    }

    /**
     * Tests the method that gets the latest values with the average parameter
     */
    public function testGetLatestValuesDataWithAverage()
    {
        // creates new api service and gets data from the method with the average parameter
        $service = new WindApiService();
        $data = $service->getLatestValuesData($average = self::AVERAGE_TEST_BOOL);

        // check that the returned data is an array
        $this->assertIsArray($data);

        // check that the returned data contains data for the value
        $this->assertNotEmpty($data);
    }
}
