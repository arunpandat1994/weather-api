<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City as CityModel;
use Http;
use Illuminate\Support\Facades\Validator;

class City extends Controller
{
    private $appid;
    private $base_url;
    private $city;
    private $state;
    private $country;
    private $lat;
    private $lon;
    
    public function __construct(Request $request){
        $this->appid = env('WEATHER_API_KEY');
        $this->base_url = \Config::get('weather-forecast-api-values.geocode-api-base-url');
        $this->city = $request->input('city');
        $this->state = $request->input('state');
        $this->country = $request->input('country');
    }


    public function getCities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required',
        ]);
 
        if ($validator->fails()) {
            $errors = $validator->errors();
            $ret['status'] = false;
            $ret['message'] = $errors->first();
            return response()->json($ret, 200);
        }
        try{
            $url = $this->base_url."q=$this->city&limit=5&appid=".$this->appid;
            $api_response = Http::get($url)->json();
            $response['status'] = true;
            $response['message'] = $api_response;
            return response()->json($response, 200);
        }catch(\Exception $e){
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            return response()->json($response, 200);
        }
    }


    public function addCity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required',
            'lat' => 'required|unique:cities,lat',
            'lon' => 'required|unique:cities,lon',
        ]);
 
        if ($validator->fails()) {
            $errors = $validator->errors();
            $ret['status'] = false;
            $ret['message'] = $errors->first();
            return response()->json($ret, 200);
        }
        try{
            $this->lat = $request->input('lat');
            $this->lon = $request->input('lon');
            $this->saveCity();
            $response['status'] = true;
            $response['message'] = "City added successfully.";
            return response()->json($response, 200);
        }catch(\Exception $e){
            $response['status'] = false;
            $response['message'] = "something went wrong";
            return response()->json($response, 200);
        }
    }

    public function saveCity(){
        $city = new CityModel();
        $city->name  = $this->city;
        $city->state  = $this->state ?? '';
        $city->country  = $this->country ?? '';
        $city->lat  = $this->lat;
        $city->lon  =  $this->lon;
        $city->save();
    }


}
