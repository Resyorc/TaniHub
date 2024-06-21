<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    protected $fillable = ['sensor_id', 'average_temperature', 'average_humidity', 'average_soil_moisture'];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
