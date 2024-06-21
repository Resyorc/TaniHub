<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SensorDataResource;
use App\Models\SensorData;
use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    public function index()
    {
        $sensorData = SensorData::all();
        return response()->json(SensorDataResource::collection($sensorData));

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|integer',
            'soil_moisture' => 'required|numeric',
            'humidity' => 'required|numeric',
            'temperature' => 'required|numeric',
        ]);

        // Save the validated data to the sensor_data table
        SensorData::create([
            'sensor_id' => $validated['device_id'],
            'average_temperature' => $validated['temperature'],
            'average_humidity' => $validated['humidity'],
            'average_soil_moisture' => $validated['soil_moisture'],
        ]);

        return response()->json(['message' => 'Sensor data processed and stored successfully'], 201);
    }
}
