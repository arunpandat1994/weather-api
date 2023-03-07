<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeatherForecastTest extends TestCase
{

    use RefreshDatabase;
    
    public function test_get_weather_forecast_all_cities()
    {
        $response = $this->get('/api/weather-forecast-all-cities');
        
        $response->assertStatus(200);
    }

    public function test_get_weather_forecast_for_lat_lon(){
        $response = $this->get('/api/weather-forecast-by-lat-lon?lat=28.6711527&lon=77.4120356');
    
        $response->assertStatus(200);
    }

}
