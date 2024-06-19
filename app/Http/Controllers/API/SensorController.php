<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;
use App\Http\Resources\SensorResource;
use Illuminate\Support\Facades\Validator;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mengambil semua data Sensor
        $Sensor = Sensor::all();

        // Mengembalikan data dalam bentuk resource collection
        return SensorResource::collection($Sensor);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'soil_moisture' => 'required|numeric',
            'humidity' => 'required|numeric',
            'temperature' => 'required|numeric',
            'device_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Create new sensor data
        $Sensor = Sensor::create($request->all());

        return response()->json(new SensorResource($Sensor), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Sensor = Sensor::find($id);

        if (is_null($Sensor)) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return new SensorResource($Sensor);
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
        // Validate input
        $validator = Validator::make($request->all(), [
            'soil_moisture' => 'numeric',
            'humidity' => 'numeric',
            'temperature' => 'numeric',
            'device_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Find sensor data
        $Sensor = Sensor::find($id);

        if (is_null($Sensor)) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Update sensor data
        $Sensor->update($request->all());

        return response()->json(new SensorResource($Sensor), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find sensor data
        $Sensor = Sensor::find($id);

        if (is_null($Sensor)) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Delete sensor data
        $Sensor->delete();

        return response()->json(null, 204);
    }
}
