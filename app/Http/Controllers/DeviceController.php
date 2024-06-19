<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Relay;
use App\Models\Sensor;

class DeviceController extends Controller
{
    //
    public function index()
    {
        $devices = Device::all(); // Fetch all devices
        return view('device', compact('devices'));
    }

    public function store(Request $request)
    {
        $device = Device::create(['name' => $request->name]);

        // Buat sensor dengan nilai default 0
        Sensor::create([
            'device_id' => $device->id,
            'soil_moisture' => 0,
            'humidity' => 0,
            'temperature' => 0
        ]);

        // Buat relay dengan status default 'off'
        Relay::create(['device_id' => $device->id, 'status' => 'off']);

        return redirect()->route('devices.index')->with('success', 'Device created successfully!');
    }

    public function create()
    {
        return view('crud.create');
    }


    public function update(Request $request, Device $device)
    {
        $validatedData = $request->validate([
            'device_name' => 'required|string|max:255',
        ]);

        $device->update($validatedData);

        return redirect()->route('devices.index')->with('success', 'Device updated successfully.');
    }

    public function edit(Device $device)
    {
        return view('crud.edit', compact('device'));
    }
    public function destroy(Device $device)
    {
        $device->delete();

        return redirect()->route('devices.index')->with('success', 'Device deleted successfully.');
    }
    public function show(Device $device)
    {
        return view('device', compact('device'));
    }
}
