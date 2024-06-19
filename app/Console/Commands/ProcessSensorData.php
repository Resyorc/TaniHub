<?php

namespace App\Console\Commands;

use App\Models\Sensor;
use App\Models\SensorData;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessSensorData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-sensor-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $endTime = Carbon::now();
        $startTime = Carbon::now()->subHour();

        $sensorData = Sensor::whereBetween('timestamp', [$startTime, $endTime])
            ->get()
            ->groupBy('sensor_id');

        foreach ($sensorData as $sensorId => $data) {
            $avgTemperature = $data->avg('temperature');
            $avgHumidity = $data->avg('humidity');
            $avgSoilMoisture = $data->avg('soil_moisture');

            SensorData::create([
                'sensor_id' => $sensorId,
                'timestamp_hourly' => $endTime->startOfHour(),
                'average_temperature' => $avgTemperature,
                'average_humidity' => $avgHumidity,
                'average_soil_moisture' => $avgSoilMoisture,
            ]);
        }

        $this->info('Sensor data processed and stored successfully.');
    }
}
