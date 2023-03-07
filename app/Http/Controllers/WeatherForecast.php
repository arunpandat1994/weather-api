<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;
use App\Models\City;
use Illuminate\Support\Facades\Validator;

class WeatherForecast extends Controller
{
    private $appid;
    private $base_url;

    public function __construct(){
        $this->appid = env('WEATHER_API_KEY');
        $this->base_url = \Config::get('weather-forecast-api-values.api-base-url');
    }
    
    
    public function getWeatherForecastAllCities(){
        try{
            $cities = $this->getAllCities();
            $weather_data = [];
            if($cities->isNotEmpty()){
                $i=0;
                foreach($cities as $city){
                    $api_response = $this->getForecastDataFromApi($city->lat, $city->lon);
                    $weather_data[$i] = $api_response['list'];
                    $i++;
                }
            }
            $response['status'] = true;
            $response['message'] = $weather_data;
            return response()->json($response, 200);
        }catch(\Exception $e){
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            return response()->json($response, 200);
        }     
    }

    public function getWeatherForecastForLatLon(Request $request){
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lon' => 'required',
        ]);
 
        if ($validator->fails()) {
            $errors = $validator->errors();
            $ret['status'] = false;
            $ret['message'] = $errors->first();
            return response()->json($ret, 200);
        }
        try{
            $i = 0;
            $lat = $request->input('lat');
            $lon = $request->input('lon');
            $api_response = $this->getForecastDataFromApi($lat, $lon);
            $weather_data[$i] = $api_response['list'];
            $response['status'] = true;
            $response['message'] = $weather_data;
            return response()->json($response, 200);
        }catch(\Exception $e){
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            return response()->json($response, 200);
        }
    }

    public function getForecastDataFromApi($lat,$lon){
        $url = $this->base_url."lat=$lat&lon=$lon&appid=".$this->appid;
        $response = Http::get($url);
        return $response->json();;
    }

    public function getAllCities(){
        $cities = City::get();
        return $cities;
    }
}
