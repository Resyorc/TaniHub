@extends('layout.sidebar')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Dashboard</h1>
            <p>Selamat datang di dashboard</p>
            <div id="content" class="p-4" :class="{ 'collapsed': sidebarCollapsed }" x-data="sensorChartComponent()" x-init="init()">
                <canvas id="sensorChart"></canvas>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/alpine.min.js"></script>
<script>
    function sensorChartComponent() {
        let chart = null;
        let isSiramInProgress = false;

        function fetchDataAndDrawChart() {
            fetch('http://tanihub.test/api/sensor-data')
                .then(response => response.json())
                .then(data => {
                    const { labels, temperatureData, humidityData, soilMoistureData } = processDataForChart(data.data);

                    // Destroy existing chart if it exists
                    if (chart) {
                        chart.destroy();
                    }

                    // Create new chart with updated data
                    const ctx = document.getElementById('sensorChart').getContext('2d');
                    chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Temperature',
                                    data: temperatureData,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    // backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: true
                                },
                                {
                                    label: 'Humidity',
                                    data: humidityData,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    // backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    fill: true
                                },
                                {
                                    label: 'Soil Moisture',
                                    data: soilMoistureData,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    // backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: true
                                }
                            ]
                        },
                        options: {
                            responsive: true, // Responsivitas dimatikan
                            // width: 1200, // Lebar canvas
                            // height: 800, // Tinggi canvas
                            scales: {
                                x: {
                                    type: 'time',
                                    time: {
                                        unit: 'day'
                                    },
                                    title: {
                                        display: true,
                                        text: 'Time'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Value'
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error updating chart:', error));
        }

        function siramTanaman() {
            // Menggunakan Alpine.js untuk mengubah nilai isSiramInProgress
            this.$data.isSiramInProgress = true;

            // Kirim permintaan untuk mengubah status relay menjadi ON
            fetch('/api/relay/status/ON', { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    console.log('Relay status: ON');
                    // Set timeout untuk mengubah status relay kembali menjadi OFF setelah 5 detik
                    setTimeout(() => {
                        fetch('/api/relay/status/OFF', { method: 'POST' })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Relay status: OFF');
                                // Menggunakan Alpine.js untuk mengubah kembali nilai isSiramInProgress
                                this.$data.isSiramInProgress = false;
                            })
                            .catch(error => {
                                console.error('Error turning off relay:', error);
                                // Menggunakan Alpine.js untuk mengubah kembali nilai isSiramInProgress jika terjadi kesalahan
                                this.$data.isSiramInProgress = false;
                            });
                    }, 10000);
                })
                .catch(error => {
                    console.error('Error turning on relay:', error);
                    // Menggunakan Alpine.js untuk mengubah kembali nilai isSiramInProgress jika terjadi kesalahan
                    this.$data.isSiramInProgress = false;
                });
        }

        return {
            init() {
                fetchDataAndDrawChart();
                setInterval(fetchDataAndDrawChart, 60000); // Update setiap 10 detik
            },
            isSiramInProgress,
            siramTanaman
        };
    }

    function processDataForChart(data) {
        const labels = data.map(sensor => new Date(sensor.created_at));
        const temperatureData = data.map(sensor => parseFloat(sensor.temperature));
        const humidityData = data.map(sensor => parseFloat(sensor.humidity));
        const soilMoistureData = data.map(sensor => parseFloat(sensor.soil_moisture));

        return { labels, temperatureData, humidityData, soilMoistureData };
    }
</script>
@endsection
