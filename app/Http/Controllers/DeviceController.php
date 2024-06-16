<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

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
        $validatedData = $request->validate([
            'device_name' => 'required|string|max:255',
            'temperature_sensor' => 'required|numeric',
            'humidity_sensor' => 'required|numeric',
            'soil_moisture_sensor' => 'required|numeric',
        ]);

        $device = Device::create($validatedData);
        // return response()->json($device, 201);
        return redirect()->route('devices.index')->with('success', 'Device created successfully.');
    }

    public function create()
{
    return view('crud.create');
}


public function update(Request $request, Device $device)
{
    $validatedData = $request->validate([
        'device_name' => 'required|string|max:255',
        'temperature_sensor' => 'required|numeric',
        'humidity_sensor' => 'required|numeric',
        'soil_moisture_sensor' => 'required|numeric',
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
