<?php
namespace Tests;

use Carbon\Carbon;
use App\Models\Values;
use App\Models\Station;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RequestsControllerTest extends TestCase
{
    /**
     * Tests the API connexion to the database
     */
    public function testDatabaseConnection()
    {
        try {
            // try to run a simple query to test the database connection
            DB::select('SELECT 1');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            // if there is an exception or error, the database connection is not working
            $this->fail('Could not connect to the database: ' . $e->getMessage());
        }
    }
    
    /**
     * Tests the API method to store the data
     */
    public function testStoreData()
    {

    }
    
    
}