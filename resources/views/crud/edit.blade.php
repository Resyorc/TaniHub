@extends('layout.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Edit Device</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="{{ route('devices.update', $device->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="device_name">Device Name</label>
                    <input type="text" class="form-control" id="device_name" name="device_name" value="{{ old('device_name', $device->device_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="temperature_sensor">Temperature Sensor</label>
                    <input type="number" class="form-control" id="temperature_sensor" name="temperature_sensor" value="{{ old('temperature_sensor', $device->temperature_sensor) }}" required>
                </div>

                <div class="form-group">
                    <label for="humidity_sensor">Humidity Sensor</label>
                    <input type="number" class="form-control" id="humidity_sensor" name="humidity_sensor" value="{{ old('humidity_sensor', $device->humidity_sensor) }}" required>
                </div>

                <div class="form-group">
                    <label for="soil_moisture_sensor">Soil Moisture Sensor</label>
                    <input type="number" class="form-control" id="soil_moisture_sensor" name="soil_moisture_sensor" value="{{ old('soil_moisture_sensor', $device->soil_moisture_sensor) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Device</button>
            </form>
        </div>
    </div>
</div>
@endsection
