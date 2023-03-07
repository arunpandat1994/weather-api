<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_get_cities(){
        $response = $this->get('/api/cities?city=ghaziabad');
        
        $response->assertStatus(200);
    }

    public function test_add_city(){
        $response = $this->post('/api/cities/create', ['city' => 'Noida', 'state' => 'Uttar Pradesh', 'country' => 'IN', 'lat' => '28.6711527', 'lon' => '77.4120356']);
 
        $response->assertStatus(200);
    }
}
