@extends('layout.sidebar')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Dashboard</h1>
            <p>Selamat datang di dashboard</p>
            <div id="content" class="p-4" :class="{ 'collapsed': sidebarCollapsed }" x-data="sensorChartComponent()" x-init="init()">
                <canvas id="sensorChart"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    function sensorChartComponent() {
        let chart = null;
        let isSiramInProgress = false;

        function fetchDataAndDrawChart() {
            fetch('http://tanihub.test/api/sensor-data')
                .then(response => response.json())
                .then(data => {
                    console.log('Data received from API:', data); // Tambahkan ini untuk debugging
                    if (!data || !Array.isArray(data)) {
                        console.error('Invalid data format:', data);
                        return;
                    }

                    const { labels, temperatureData, humidityData, soilMoistureData } = processDataForChart(data);

                    // Destroy existing chart if it exists
                    if (chart) {
                        chart.destroy();
                    }

                    // Check if canvas exists
                    const ctx = document.getElementById('sensorChart');
                    if (!ctx) {
                        console.error('Canvas element not found!');
                        return;
                    }

                    // Create new chart with updated data
                    chart = new Chart(ctx.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Temperature',
                                    data: temperatureData,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    fill: true
                                },
                                {
                                    label: 'Humidity',
                                    data: humidityData,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    fill: true
                                },
                                {
                                    label: 'Soil Moisture',
                                    data: soilMoistureData,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    fill: true
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    type: 'time',
                                    time: {
                                        unit: 'minute'
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


        return {
            init() {
                fetchDataAndDrawChart();
                setInterval(fetchDataAndDrawChart, 180000); // Update setiap 1 menit
            },
        };
    }

    function processDataForChart(data) {
        const labels = data.map(sensor => new Date(sensor.created_at));
        const temperatureData = data.map(sensor => parseFloat(sensor.average_temperature));
        const humidityData = data.map(sensor => parseFloat(sensor.average_humidity));
        const soilMoistureData = data.map(sensor => parseFloat(sensor.average_soil_moisture));

        return { labels, temperatureData, humidityData, soilMoistureData };
    }
</script>

@endsection
