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
                            <canvas id="principal_total_sales" height="50"></canvas>
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
        const principal_yearly_sales_result_principal = {!! json_encode($principal_yearly_sales_result_principal) !!};
        const principal_yearly_sales_result_sales = {!! json_encode($principal_yearly_sales_result_sales) !!};


        var pie_chart_data = [{
            data: principal_yearly_sales_result_sales,
            backgroundColor: [
                "#4b77a9",
                "#5f255f",
                "#d21243",
                "#B27200",
                "green",
                "burlywood",
                "aquamarine"
            ],
            borderColor: "#fff"
        }];

        var options = {
            tooltips: {
                enabled: false
            },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        const datapoints = ctx.chart.data.datasets[0].data
                        const total = datapoints.reduce((total, datapoint) => total + datapoint, 0)
                        const percentage = value / total * 100
                        return percentage.toFixed(2) + "%";
                    },
                    color: '#fff',
                }
            }

        };

        var principal_total_sales = document.getElementById("principal_total_sales").getContext('2d');
        var pie_chart = new Chart(principal_total_sales, {
            type: 'pie',
            data: {
                labels: principal_yearly_sales_result_principal,
                datasets: pie_chart_data
            },
            options: options,
            plugins: [ChartDataLabels],
        });
      
    </script>
    </body>

    </html>
@endsection
