<?php

namespace App\Http\Controllers;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
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
