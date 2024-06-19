<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = ['device_id', 'soil_moisture', 'humidity', 'temperature'];

    public function sensorData()
    {
        return $this->hasMany(SensorData::class);
    }
}
