<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\SensorData;

class ProcessSensorData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sensor:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch sensor data from API and store in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Endpoint to get sensor data
        $getSensorDataEndpoint = url('http://localhost:8000/api/sensor');

        // Make a request to the /api/sensor endpoint to get the data
        $response = Http::get($getSensorDataEndpoint);

        if ($response->successful()) {
            // Assuming the /api/sensor returns a JSON response with the required fields
            $sensorData = $response->json();

            // Loop through each sensor data to save to the database
            foreach ($sensorData as $data) {
                // Check if all required fields are present and valid
                if (
                    isset($data['device_id']) && isset($data['temperature']) && isset($data['humidity']) && isset($data['soil_moisture']) &&
                    is_numeric($data['device_id']) && is_numeric($data['temperature']) && is_numeric($data['humidity']) && is_numeric($data['soil_moisture'])
                ) {
                    // Save data to the database
                    SensorData::create([
                        'sensor_id' => $data['device_id'],
                        'average_temperature' => $data['temperature'],
                        'average_humidity' => $data['humidity'],
                        'average_soil_moisture' => $data['soil_moisture'],
                    ]);
                } else {
                    // Log invalid data for debugging
                    Log::error('Invalid sensor data received', [
                        'data' => $data,
                        'missing_or_invalid_fields' => [
                            'device_id' => isset($data['device_id']) && is_numeric($data['device_id']),
                            'temperature' => isset($data['temperature']) && is_numeric($data['temperature']),
                            'humidity' => isset($data['humidity']) && is_numeric($data['humidity']),
                            'soil_moisture' => isset($data['soil_moisture']) && is_numeric($data['soil_moisture']),
                        ]
                    ]);
                }
            }
        } else {
            // Log error if unable to fetch sensor data
            Log::error('Failed to fetch sensor data from API', ['status' => $response->status(), 'body' => $response->body()]);
        }

        $this->info('Sensor data processing completed.');
    }
}
