<?php

namespace App\Http\Controllers;

use App\Models\QueriesHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Validation\ValidationException;

class QueriesHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $queriesHistory = QueriesHistory::with('country', 'city')->latest()->take(5)->get();

            if ($queriesHistory->isEmpty()) {
                throw new \Exception('No se encontró un historial');
            }
            return response()->json($queriesHistory);
        } catch (QueryException $e) {
            Log::error('Error al obtener historico: ' . $e->getMessage());
            throw new Exception('Ha ocurrido un error inesperado. Por favor, inténtelo de nuevo más tarde');
        } catch (\Throwable $th) {
            Log::error('Error al obtener historico: ' . $th->getMessage());
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

        try {
            $validatedData = $request->validate([
                'country_id' => 'required|integer|exists:countries,id',
                'city_id' => 'required|integer|exists:cities,id',
                'budget' => 'required|numeric',
                'exchange_rate' => 'required|numeric',
                'converted_budget' => 'required|numeric',
            ]);


            $queryHistory = QueriesHistory::create($validatedData);
            return response()->json(["success"=>true,"message" => 'Historial guardado correctamente.'], Response::HTTP_CREATED);

        } catch (ValidationException $ve) {
            return response()->json(['errors' => $ve->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $th) {
            Log::error('Error al guardar historial: ' . $th->getMessage());

            return response()->json(["success"=>false,"message" => 'Un error inesperado ha ocurrido al intentar guardaer el historial.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
