<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SensorDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sensor_id' => $this->sensor_id,
            'timestamp' => $this->timestamp,
            'average_temperature' => $this->average_temperature,
            'average_humidity' => $this->average_humidity,
            'average_soil_moisture' => $this->average_soil_moisture,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
