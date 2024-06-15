<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SensorData;
use Illuminate\Http\Request;
use App\Http\Resources\SensorResource;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SensorResource::collection(SensorData::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sensorData = SensorData::create($request->all());
        return response()->json($sensorData, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sensorData = SensorData::find($id);
        if (is_null($sensorData)) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        return new SensorResource($sensorData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sensorData = SensorData::find($id);
        if (is_null($sensorData)) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        $sensorData->update($request->all());
        return response()->json($sensorData, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sensorData = SensorData::find($id);
        if (is_null($sensorData)) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        $sensorData->delete();
        return response()->json(null, 204);
    }
}
