@extends('layout.dashboard')

@section('content')
    <div class="container mt-5">
        <h1>Tambah Perangkat Baru</h1>
        <form action="{{ route('devices.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="device_name">Nama Perangkat</label>
                <input type="text" class="form-control" id="device_name" name="device_name" required>
            </div>
            <div class="form-group">
                <label for="temperature_sensor">Sensor Suhu</label>
                <input type="number" step="0.01" class="form-control" id="temperature_sensor" name="temperature_sensor" required>
            </div>
            <div class="form-group">
                <label for="humidity_sensor">Sensor Kelembaban Udara</label>
                <input type="number" step="0.01" class="form-control" id="humidity_sensor" name="humidity_sensor" required>
            </div>
            <div class="form-group">
                <label for="soil_moisture_sensor">Sensor Kelembaban Tanah</label>
                <input type="number" step="0.01" class="form-control" id="soil_moisture_sensor" name="soil_moisture_sensor" required>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Tambah Perangkat</button>
        </form>
    </div>
@endsection
