<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'device';
    protected $fillable = [
        'device_name',
        'temperature_sensor',
        'humidity_sensor',
        'soil_moisture_sensor',
    ];
}
