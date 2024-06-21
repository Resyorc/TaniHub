<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Sensor;

class FetchSensorData extends Command
{
    protected $signature = 'sensor:fetch';
    protected $description = 'Fetch sensor data from API';

    public function handle()
    {
        $response = Http::get('http://localhost:8000/api/sensor');

        if ($response->successful()) {
            $sensorData = $response->json()['data'];

            foreach ($sensorData as $data) {
                Sensor::create([
                    'temperature' => $data['temperature'],
                    'humidity' => $data['humidity'],
                    'soil_moisture' => $data['soil_moisture'],
                    'created_at' => $data['created_at'], // Pastikan format sesuai dengan yang diterima dari API
                ]);
            }

            $this->info('Sensor data fetched successfully.');
        } else {
            $this->error('Failed to fetch sensor data.');
        }
    }

}
