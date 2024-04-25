<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Http;
use Throwable;
use Illuminate\Http\Response;
class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $countries = Country::all();
            if ($countries->isEmpty()) {
                throw new \Exception('No se encontraron países');
            }
            return response()->json($countries);
        } catch (QueryException $e) {
            Log::error('Error al obtener los países: ' . $e->getMessage());
            throw new \Exception('Ocurrió un error al obtener los países. Por favor, inténtelo de nuevo más tarde.');
        } catch (Throwable $th) {
            Log::error('Error al obtener los países: ' . $th->getMessage());
            throw new \Exception($th->getMessage());
        }
    }

    //Traer la moneda local para el pais seleccionado
    public function getCurrencyByCountry($country_id){        
        try {

            if (empty($country_id) || !is_numeric($country_id)) {
                return response()->json(['error' => 'Debe proporcionar un id valido para la consulta'], Response::HTTP_BAD_REQUEST);   
            }
            $countryCurrency = Currency::with('country')->where('country_id',$country_id)->first();
            
            if (!$countryCurrency) {
                throw new \Exception('No se encontraron monedas locales para el país seleccionado');
            }

            $exchangeCalculation = $this->getExchange($countryCurrency->country->id);

            $currencyInfo = [
                "name"   => $countryCurrency->name,
                "symbol" => $countryCurrency->symbol
            ];
        
            return response()->json(["success" => true, "exchange" => $exchangeCalculation, "info" => $currencyInfo]);
        } catch (\Throwable $th) {
            Log::error('Error fetching currencies: ' . $th->getMessage());
            return response()->json(['error' => $th->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    //Obtener el cambio de la moneda del país seleccionado y COP
    private function getExchange($country_id){
        $country = Country::find($country_id);
        
        if (empty($country)) {
            return response()->json(['error' => 'Debe proporcionar un ID válido de un país.'], Response::HTTP_BAD_REQUEST);
        }
    
        $exchangeAPIKey = env('EXCHANGE_API_KEY');
        $url = "https://v6.exchangerate-api.com/v6/".$exchangeAPIKey."/latest/".$country->code;
    
        try {
            $response = Http::get($url);
    
            if ($response->successful()) {

                $jsonContent = $response->body();
                $responseData = json_decode($jsonContent, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Error al decodificar la respuesta JSON');
                }

                $copRate = $responseData['conversion_rates']['COP'] ?? null;
                $countryCodeRate = $responseData['conversion_rates'][$country->code];
                $formattedCopRate = round($copRate / 1000, 3);
                
                if (is_null($countryCodeRate)) {
                    return response()->json(["success"=> false, "message" => "No se encontró la tasa de cambio para $country->name($countryCodeRate)."], Response::HTTP_BAD_REQUEST);
                }

                if (is_null($copRate)) {
                    return response()->json(["success" => false, "message" => 'No se encontró la tasa de cambio para COP.'], Response::HTTP_BAD_REQUEST);
                }
    
                return ['COP' => $formattedCopRate, 'countryRate' => $countryCodeRate];

            } else {
                $jsonContent = $response->body();
                $errorData = json_decode($jsonContent, true);
                $errorMessage = $errorData['error'] ?? 'Error desconocido al obtener los datos de cambio de moneda.';
                
                return response()->json(['error' => $errorMessage], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Error fetching exchange rates: ' . $e->getMessage());
            return response()->json(['error' => 'Error al conectar con la API de tasas de cambio: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
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
