<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SensorResource;
use App\Models\Sensor;
use App\Models\SensorData;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    public function index()
    {
        $sensorData = SensorData::all();
        return SensorResource::collection($sensorData);
    }

    public function processSensorData()
    {
        $endTime = Carbon::now();
        $startTime = Carbon::now()->subHour();

        // Mengambil data sensor dalam rentang waktu yang ditentukan
        $sensorData = Sensor::whereBetween('updated_at', [$startTime, $endTime])->get();

        // Mengelompokkan data berdasarkan sensor_id
        $groupedData = $sensorData->groupBy('sensor_id');

        foreach ($groupedData as $sensorId => $data) {
            $avgTemperature = $data->avg('temperature');
            $avgHumidity = $data->avg('humidity');
            $avgSoilMoisture = $data->avg('soil_moisture');

            // Validasi bahwa sensor_id tidak kosong
            if ($sensorId !== null) {
                SensorData::create([
                    'sensor_id' => $sensorId,
                    'timestamp' => $endTime->format('Y-m-d H:00:00'),
                    'average_temperature' => $avgTemperature,
                    'average_humidity' => $avgHumidity,
                    'average_soil_moisture' => $avgSoilMoisture,
                ]);
            }// else {
            //     \Log::warning("Sensor ID is null for the data group: " . json_encode($data));
            // }
        }

        return response()->json(['message' => 'Sensor data processed and stored successfully.']);
    }
}
