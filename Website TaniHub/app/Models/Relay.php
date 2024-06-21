<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relay extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'status'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
