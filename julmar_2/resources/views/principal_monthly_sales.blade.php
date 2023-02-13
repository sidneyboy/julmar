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
                                <span id="sales_per_year_current_month_hide">Principal Sales From
                                    {{ $selected_label_date_range }}</span>
                            </h3>

                        </div>
                        <div class="card-body">
                            <canvas id="principal_monthly_sales_canvas" height="100"></canvas>
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
        const principal_monthly_sales_result_principal = {!! json_encode($principal_monthly_sales_result_principal) !!};
        const principal_monthly_sales_result_sales = {!! json_encode($principal_monthly_sales_result_sales) !!};
        
        var principal_monthly_data = principal_monthly_sales_result_principal;
        var principal_monthly_sales = principal_monthly_sales_result_sales;
        var barColors = ["red", "green", "blue", "orange", "brown", "4b77a9", "#5f255f",
            "#d21243",
            "#B27200",
            "green",
            "burlywood",
            "aquamarine"
        ];

        new Chart("principal_monthly_sales_canvas", {
            type: "bar",
            data: {
                labels: principal_monthly_data,
                datasets: [{
                    backgroundColor: barColors,
                    data: principal_monthly_sales
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: "Agent Performance For the Month of ",
                    }
                }
            }
        });
    </script>
    </body>

    </html>
@endsection
