<?php

namespace App\Http\Controllers;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($country_id)
    {
        if (empty($country_id) || !is_numeric($country_id)) {
            return response()->json(['error' => 'Debe proporcionar un id valido para la consulta'], Response::HTTP_BAD_REQUEST);
        }
        try {
            $cities = City::with('country')->whereHas('country', function ($query) use ($country_id) {
                $query->where('id', $country_id);
            })->get();

            if ($cities->isEmpty()) {
                throw new \Exception('No se encontraron ciudades para el país seleccionado');
            }
            return response()->json($cities);
        } catch (\Throwable $th) {
            Log::error('Error fetching cities: ' . $th->getMessage());
            return response()->json(['error' => $th->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function getWeatherByCity($city_id){
        $cityName = $city_id;
        
        if (empty($cityName)) {
            return response()->json(['error' => 'Debe proporcionar el nombre de una ciudad.'], Response::HTTP_BAD_REQUEST);
        }

        $apiKey = env('WEATHER_API_KEY');
        $url = "https://api.openweathermap.org/data/2.5/weather";
        // dd($cityName, $apiKey, $url);
        try {
            $response = Http::get($url, [
                'appid' => $apiKey,
                'q'     => $cityName,
                'units' => 'imperial',
                'lang'  => 'es'
            ]);
            // dd($response);
            if ($response->successful()) {
                return $response->json();
            } else {
                return response()->json(['error' => 'Error al obtener los datos meteorológicos.'], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching cities: ' . $e->getMessage());
            return response()->json(['error' => 'Error al conectar con la API de Weather: '], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
