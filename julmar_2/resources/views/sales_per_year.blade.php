@extends('layouts.master')

@section('title', 'VS DASHBOARD')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-12">
                    <div class="card" id="sales_div_refresh">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                <span id="sales_per_year_current_month_hide">Sales From
                                    {{ $selected_label_date_range }}</span>
                            </h3>

                        </div>
                        <div class="card-body">
                            <canvas id="selected_monthly_sales" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('footer')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js">
    </script>

    <script type="text/javascript">
        const sales_selected_labels = {!! json_encode($sales_selected_labels) !!};
        const sales_selected_data = {!! json_encode($sales_selected_data) !!};
        const selected_monthly_sales_const = document.getElementById('selected_monthly_sales').getContext('2d');
        const sales_selected_myChart = new Chart(selected_monthly_sales_const, {
            type: 'line',
            data: {
                labels: sales_selected_labels, // <======= Here I set the x-axis
                datasets: [{
                    label: '',
                    data: sales_selected_data, // <======= Here I set the y-axis
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
    </body>

    </html>
@endsection
