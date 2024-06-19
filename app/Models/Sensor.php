<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;
    protected $fillable = [
        'device_id',
        'soil_moisture',
        'humidity',
        'temperature',
    ];
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
