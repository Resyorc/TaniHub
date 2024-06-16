<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Relay;
use Illuminate\Http\Request;

class RelayController extends Controller
{
    public function getStatus()
    {
        $relay = Relay::first();
        return response()->json(['status' => $relay->status]);
    }

    public function setStatus(Request $request, $status)
    {
        $relay = Relay::first();
        if ($relay) {
            $relay->status = strtoupper($status);
            $relay->save();
        } else {
            Relay::create(['status' => strtoupper($status)]);
        }

        return response()->json(['status' => 'success', 'relay_status' => $status]);
    }
}
