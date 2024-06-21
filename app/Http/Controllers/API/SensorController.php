<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\SensorData;
use Illuminate\Http\Request;
use App\Http\Resources\SensorResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\SensorDataResource;
use Illuminate\Support\Facades\Log;


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
        $sensors = Sensor::all();

        // Mengembalikan data dalam bentuk resource collection
        return response()->json(SensorResource::collection($sensors));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|integer',
            'soil_moisture' => 'required|numeric|min:0|max:100',
            'humidity' => 'required|numeric|min:0|max:100',
            'temperature' => 'required|numeric',
        ]);

        Log::info('Data yang divalidasi: ', $validated);

        // Simpan data ke tabel sensors
        $sensor = Sensor::create($validated);

        // Simpan data ke tabel sensor_data
        SensorData::create([
            'sensor_id' => $sensor->id,
            'average_temperature' => $validated['temperature'],
            'average_humidity' => $validated['humidity'],
            'average_soil_moisture' => $validated['soil_moisture'],
        ]);

        return response()->json(['message' => 'Sensor data stored and processed successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sensor = Sensor::find($id);

        if (is_null($sensor)) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return response()->json(SensorResource::collection($sensor));
    }


    public function showSensorData($id)
    {
        $sensorData = SensorData::find($id);

        if (is_null($sensorData)) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return response()->json(SensorDataResource::collection($sensorData));
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
