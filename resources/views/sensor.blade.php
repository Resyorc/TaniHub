@extends('layout.sidebar')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Sensor Data</h1>
            <div x-data="sensorDataComponent()" x-init="init()">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Temperature</h5>
                                <p class="card-text" x-text="temperature"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Humidity</h5>
                                <p class="card-text" x-text="humidity"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Soil Moisture</h5>
                                <p class="card-text" x-text="soilMoisture"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary" @click="siramTanaman" :disabled="isSiramInProgress">
                        <span x-show="!isSiramInProgress">Siram Tanaman</span>
                        <span x-show="isSiramInProgress">Sedang Menyiram...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function sensorDataComponent() {
        return {
            temperature: 'Loading...',
            humidity: 'Loading...',
            soilMoisture: 'Loading...',
            isSiramInProgress: false,
            init() {
                this.fetchData();
                setInterval(() => {
                    this.fetchData();
                }, 5000); // Update setiap 5 detik
            },
            fetchData() {
                fetch('http://tanihub.test/api/sensor')
                    .then(response => response.json())
                    .then(data => {
                        console.log('Data received from API:', data); // Debugging
                        if (!data || !Array.isArray(data)) {
                            console.error('Invalid data format:', data);
                            return;
                        }

                        // Assuming data contains an array of sensor readings
                        const latestSensorData = data[data.length - 1];
                        this.temperature = latestSensorData.temperature + ' °C';
                        this.humidity = latestSensorData.humidity + ' %';
                        this.soilMoisture = latestSensorData.soil_moisture + ' %';
                    })
                    .catch(error => console.error('Error fetching sensor data:', error));
            },
            siramTanaman() {
                this.isSiramInProgress = true;

                fetch('/api/relay/status/ON', { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Relay status: ON');
                        setTimeout(() => {
                            fetch('/api/relay/status/OFF', { method: 'POST' })
                                .then(response => response.json())
                                .then(data => {
                                    console.log('Relay status: OFF');
                                    this.isSiramInProgress = false;
                                })
                                .catch(error => {
                                    console.error('Error turning off relay:', error);
                                    this.isSiramInProgress = false;
                                });
                        }, 10000); // 10 detik
                    })
                    .catch(error => {
                        console.error('Error turning on relay:', error);
                        this.isSiramInProgress = false;
                    });
            }
        };
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
@endsection