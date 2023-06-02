<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 02.06.2023
 * Description : Wind Controller Test class that tests methods of the website controller
 */

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase; does not work

use Tests\TestCase;

use Illuminate\Http\Request;

class WindControllerTest extends TestCase
{   
    // hours number test value
    private const NUMBER_HOURS_TEST = 24;

    /**
     * Tests the renderHome method that renders the home page
     */
    public function testRenderHome()
    {
        // send a GET request to the root URL (home page)
        $response = $this->get('/');

        // check that the response is successful
        $response->assertStatus(200);

        // check that the returned view is the 'home' view
        $response->assertViewIs('home');

        // check that the view contains its data
        $response->assertViewHas('lastHours');
    }

     /**
     * Tests the renderHomeLastHours method that renders the home page with input form data 
     */
    public function testRenderHomeLastHours()
    {
        // create a new GET request to the root URL with the hours parameter
        Request::create('/', 'GET', ['hours' => self::NUMBER_HOURS_TEST]);

        // send a GET request to the home URL hours parameter
        $response = $this->call('GET', '/', ['hours' => self::NUMBER_HOURS_TEST]);

        // check that the response is successful
        $response->assertStatus(200);

        // check that the returned view is the 'home' view
        $response->assertViewIs('home');

        // check that the view contains its data
        $response->assertViewHas('lastHours', self::NUMBER_HOURS_TEST);
    }

     /**
     * Tests the renderStations method that renders the stations page
     */
    public function testRenderStations()
    {
        // send a GET request to the stations URL
        $response = $this->get('/stations');

        // check that the response is successful
        $response->assertStatus(200);

        // check that the returned view is the 'stations' view
        $response->assertViewIs('stations');

        // check that the view contains its data
        $response->assertViewHas('data');
    }

     /**
     * Tests the renderAbout method that renders the about page
     */
    public function testRenderAbout()
    {
        // send a GET request to the about URL
        $response = $this->get('/about');

        // check that the response is successful
        $response->assertStatus(200);

        // check that the returned view is the 'about' view
        $response->assertViewIs('about');
    }

     /**
     * Tests the renderContact method that renders the contact page
     */
    public function testRenderContact()
    {
       // send a GET request to the contact URL
       $response = $this->get('/contact');

       // check that the response is successful
       $response->assertStatus(200);

       // check that the returned view is the 'contact' view
       $response->assertViewIs('contact');
    }
}