@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- pengunjung bulan ini -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card card-info mt-4">
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="myChart" width="400" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>

<script>
    situmpurPengunjung();
    function situmpurPengunjung() {
        $.ajax({
            url: '{{ URL::route("dashboard.situmpur_pengunjung") }}',
            type: 'get',
            success: function (response) {
                const ctx = document.getElementById('myChart').getContext('2d');
                let data_labels = response.tanggal_pengunjung;
                const myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data_labels,
                        datasets: [{
                            label: 'Data Pengunjung',
                            data: response.total_pengunjung,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        })
    }
</script>

@endsection

