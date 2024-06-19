@extends('layout.sidebar')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Periksa Hubungan Perangkatmu di sini!</h1>
            <p>pantau..</p>
        </div>
        <div class="container mt-4">
            <h2>Data Devices & Sensors</h2>
            <a href="{{ route('devices.create') }}" class="btn btn-success mb-3">Tambah</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Device</th>
                        <th>Sensor Suhu</th>
                        <th>Sensor Kelembaban Udara</th>
                        <th>Sensor Kelembaban Tanah</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                        <tr>
                            <td>{{ $device->id }}</td>
                            <td>{{ $device->name }}</td>
                            <td>{{ $device->temperature_sensor }}°C</td>
                            <td>{{ $device->humidity_sensor }}%</td>
                            <td>{{ $device->soil_moisture_sensor }}%</td>
                            <td>
                                <a href="{{ route('devices.edit', $device->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('devices.destroy', $device->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection