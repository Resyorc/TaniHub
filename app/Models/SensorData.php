<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;
    protected $fillable = [
        'sensor_id',
        'timestamp_hourly',
        'average_temperature',
        'average_humidity',
        'average_soil_moisture'
    ];

    // Jika diperlukan, Anda bisa menambahkan hubungan (relationship) di sini
    public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'sensor_id', 'id');
    }
}
