
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
                <section class="col-lg-7 connectedSortable">
                    <div class="card" id="sales_div_refresh">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                <span id="sales_per_year_current_month_hide">Sales</span>
                            </h3>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('sales_per_year') }}" method="post" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right reservation_class"
                                                name="date_range">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" id="sales_button"
                                            class="btn btn-success btn-block float-right">Search</button>

                                        <button style="display:none;" id="sales_button_show_if_trigger"
                                            class="btn btn-warning btn-block float-right">Prepare for Next Query</button>
                                    </div>
                                </div>
                            </form>
                            <br />
                            <div id="sales_per_year_page" style="display: none"></div>
                            <canvas id="monthly_sales" height="100"></canvas>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Agent Performance</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('agent_monthly_performance') }}" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right reservation_class"
                                                name="date_range">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" id="sales_button"
                                            class="btn btn-success btn-block float-right">Search</button>

                                        <button style="display:none;" id="sales_button_show_if_trigger"
                                            class="btn btn-warning btn-block float-right">Prepare for Next Query</button>
                                    </div>
                                </div>
                            </form>
                            <br />
                            <div id="agent_monthly_performance_page" style="display: none"></div>
                            <br />
                            <canvas id="agent_montly_sales_canvas"></canvas>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>



                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ion ion-clipboard mr-1"></i>
                                Principal Monthly Sales
                            </h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="post" action="{{ route('principal_monthly_sales') }}" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right reservation_class"
                                                name="date_range">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" id="sales_button"
                                            class="btn btn-success btn-block float-right">Search</button>

                                        <button style="display:none;" id="sales_button_show_if_trigger"
                                            class="btn btn-warning btn-block float-right">Prepare for Next Query</button>
                                    </div>
                                </div>
                            </form>
                            <canvas id="principal_monthly_sales_canvas"></canvas>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">

                        </div>
                    </div>



                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ion ion-clipboard mr-1"></i>
                                Top Performing Agent - Sales
                                <span
                                    id="top_10_agent_sales_hide_month">({{ $monthName = date('F', mktime(0, 0, 0, $month, 10)) . ' - ' . $year }})</span>
                            </h3>

                        </div>

                        <div class="card-body">
                            <form id="search_top_10_agent_sales_per_month">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right reservation_class"
                                                name="date_range">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" min="0" name="top_number"
                                            required placeholder="Top #">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit"
                                            class="btn btn-success btn-block float-right">Search</button>
                                    </div>
                                </div>
                            </form>

                            <br />
                            <div id="search_top_10_agent_sales_per_month_page" style="display: none"></div>
                            <table class="table table-bordered table-hover table-sm"
                                id="top_10_agent_sales_hide_current_table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Agent</th>
                                        <th>Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($top_10_agent_data != 0)
                                        @for ($i = 0; $i < count($top_10_agent_data); $i++)
                                            <tr>
                                                <td style="text-align: center">
                                                    @php
                                                        echo $number_series;
                                                        $number_series++;
                                                    @endphp
                                                </td>
                                                <td>{{ $top_10_agent_data[$i]->store_name }}</td>
                                                <td style="text-align: right">
                                                    {{ number_format($top_10_agent_sales[$i]['total_sales'], 2, '.', ',') }}
                                                    @php
                                                        $top_10_agent_sales_total[] = $top_10_agent_sales[$i]['total_sales'];
                                                    @endphp
                                                </td>
                                            </tr>
                                        @endfor
                                    @else
                                        @php
                                            $top_10_agent_sales_total[] = $top_10_agent_sales[$i]['total_sales'];
                                        @endphp
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:right">
                                            {{ number_format(array_sum($top_10_agent_sales_total), 2, '.', ',') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="card-footer clearfix">

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ion ion-clipboard mr-1"></i>
                                Highest Store Sales
                                <span
                                    id="top_10_highest_store_sales_hide_month">({{ $monthName = date('F', mktime(0, 0, 0, $month, 10)) . ' - ' . $year }})</span>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="top_10_highest_store_sales">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right reservation_class"
                                                name="date_range">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" min="0" name="top_number"
                                            required placeholder="Top #">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit"
                                            class="btn btn-success btn-block float-right">Search</button>
                                    </div>
                                </div>
                            </form>

                            <br />
                            <div id="top_10_highest_store_sales_page" style="display: none"></div>

                            <table class="table table-bordered table-hover table-sm"
                                id="top_10_highest_store_sales_hide_current_table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Location</th>
                                        <th>Store Name</th>
                                        <th>Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($top_10_stores_sales as $store_sales)
                                        <tr>
                                            <td style="text-align: center">
                                                @php
                                                    echo $number_series_3;
                                                    $number_series_3++;
                                                @endphp
                                            </td>
                                            <td>{{ $store_sales['location'] }}</td>
                                            <td>{{ $store_sales['store_name'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($store_sales['total_sales'], 2, '.', ',') }}
                                                @php
                                                    $top_10_stores_sales_total[] = $store_sales['total_sales'];
                                                @endphp
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ number_format(array_sum($top_10_stores_sales_total), 2, '.', ',') }}</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">

                        </div>
                    </div>
                </section>
                <section class="col-lg-5 connectedSortable">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                Total Sales of Principal ( 2022 Percentage )
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"
                                    data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('principal_yearly_sales') }}" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right reservation_class"
                                                name="date_range">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" id="sales_button"
                                            class="btn btn-success btn-block float-right">Search</button>

                                        <button style="display:none;" id="sales_button_show_if_trigger"
                                            class="btn btn-warning btn-block float-right">Prepare for Next Query</button>
                                    </div>
                                </div>
                            </form><br />
                            <canvas id="principal_total_sales"></canvas>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-th mr-1"></i>
                                LOCATION SALES
                                ({{ $monthName = date('F', mktime(0, 0, 0, $month, 10)) . ' - ' . $year }})


                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn bg-default btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('location_sales') }}" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right reservation_class"
                                                name="date_range">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" id="sales_button"
                                            class="btn btn-success btn-block float-right">Search</button>

                                        <button style="display:none;" id="sales_button_show_if_trigger"
                                            class="btn btn-warning btn-block float-right">Prepare for Next Query</button>
                                    </div>
                                </div>
                            </form><br />
                            <canvas id="location_total_sales"></canvas>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title" style="color:red;">
                                <i class="fas fa-th mr-1"></i>
                                DESISYONAN PAJUD NATO NI!
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn bg-default btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="location_total_sales"></canvas>
                        </div>
                        <!-- /.card-body -->
                    </div>



                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-th mr-1"></i>
                                TOP SKU <span
                                    id="top_10_sku_current_month_hide">({{ $monthName = date('F', mktime(0, 0, 0, $month, 10)) . ' - ' . $year }})</span>
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn bg-default btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="top_10_sku">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right reservation_class"
                                                name="date_range">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" min="0" name="top_number"
                                            required placeholder="Top #">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="principal" class="form-control select2" style="width:100%;"
                                            required>
                                            <option value="" default>Principal</option>
                                            @foreach ($principal as $principal_data)
                                                <option value="{{ $principal_data->principal }}">
                                                    {{ $principal_data->principal }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit"
                                            class="btn btn-success btn-block float-right">Search</button>
                                    </div>
                                </div>
                            </form>

                            <br />
                            <div id="top_10_sku_page" style="display: none"></div>

                            <table class="table table-bordered table-hover table-sm" id="top_10_sku_hide_current_table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Desc</th>
                                        <th>U/P</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($top_10_sku_sales as $top_10_sku_sales_data)
                                        <tr>
                                            <td style="text-align: center">
                                                @php
                                                    echo $number_series_2;
                                                    $number_series_2++;
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $top_10_sku_sales_data['description'] }} <br /> <span
                                                    style="color:blue">{{ $top_10_sku_sales_data['principal'] }}</span>
                                                -
                                                <span style="color:red">{{ $top_10_sku_sales_data['sku_code'] }}</span>

                                            </td>
                                            <td style="text-align: right">
                                                {{ number_format($top_10_sku_sales_data['total_quantity']) }}
                                            </td>
                                            <td style="text-align: right">
                                                {{ number_format($top_10_sku_sales_data['unit_price'], 2, '.', ',') }}
                                            </td>
                                            <td style="text-align: right">
                                                {{ number_format($top_10_sku_sales_data['total_sales'], 2, '.', ',') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </section>
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
    <script>
        $("#search_top_10_agent_sales_per_month").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            $.ajax({
                url: "search_top_10_agent_sales_per_month",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.loading').hide();
                    $('#top_10_agent_sales_hide_current_table').hide();
                    $('#top_10_agent_sales_hide_month').hide();
                    $('#search_top_10_agent_sales_per_month_page').show();
                    $('#search_top_10_agent_sales_per_month_page').html(data);
                },
            });
        }));

        $("#top_10_highest_store_sales").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            $.ajax({
                url: "top_10_highest_store_sales",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.loading').hide();
                    $('#top_10_highest_store_sales_hide_current_table').hide();
                    $('#top_10_highest_store_sales_hide_month').hide();
                    $('#top_10_highest_store_sales_page').show();
                    $('#top_10_highest_store_sales_page').html(data);
                },
            });
        }));

        $("#top_10_sku").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            $.ajax({
                url: "top_10_sku",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.loading').hide();
                    $('#top_10_sku_hide_current_table').hide();
                    $('#top_10_sku_current_month_hide').hide();
                    $('#top_10_sku_page').show();
                    $('#top_10_sku_page').html(data);
                },
            });
        }));
    </script>
    <script>
        // DATA FROM PHP TO JAVASCRIPT
        const labels = {!! json_encode($labels) !!};
        const data = {!! json_encode($data) !!};

        const monthly_principal_sales_result_principal = {!! json_encode($monthly_principal_sales_result_month) !!};
        const monthly_principal_sales_result_sales = {!! json_encode($monthly_principal_sales_result_sales) !!};

        const monthly_agent_sales_result_sales = {!! json_encode($monthly_agent_sales_result_sales) !!};
        const monthly_agent_sales_result_name = {!! json_encode($monthly_agent_sales_result_name) !!};

        const principal_monthly_sales_result_principal = {!! json_encode($principal_monthly_sales_result_principal) !!};
        const principal_monthly_sales_result_sales = {!! json_encode($principal_monthly_sales_result_sales) !!};

        const monthly_location_sales_result_sales = {!! json_encode($monthly_location_sales_result_sales) !!};
        const monthly_location_sales_result_location = {!! json_encode($monthly_location_sales_result_location) !!};
    </script>
    <script type="text/javascript">
        const monthly_sales_const = document.getElementById('monthly_sales').getContext('2d');
        const myChart = new Chart(monthly_sales_const, {
            type: 'line',
            data: {
                labels: labels, // <======= Here I set the x-axis
                datasets: [{
                    label: 'Total Sales For the Year of ' + <?php echo $year; ?>,
                    data: data, // <======= Here I set the y-axis
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
                }
            }
        });

        ///////////////////////////////////////pie chart below

        var pie_chart_data = [{
            data: monthly_principal_sales_result_sales,
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
                labels: monthly_principal_sales_result_principal,
                datasets: pie_chart_data
            },
            options: options,
            plugins: [ChartDataLabels],
        });

        //////////////////////////////////////agent monthly performance

        var agent_data = monthly_agent_sales_result_name;
        var agent_sales = monthly_agent_sales_result_sales;
        var barColors = ["red", "green", "blue", "orange", "brown", "4b77a9", "#5f255f",
            "#d21243",
            "#B27200",
            "green",
            "burlywood",
            "aquamarine"
        ];

        new Chart("agent_montly_sales_canvas", {
            type: "bar",
            data: {
                labels: agent_data,
                datasets: [{
                    backgroundColor: barColors,
                    data: agent_sales
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

        //////////////////////////////////////principal monthly performance

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

        //////////////////////////////////////////doughnut
        var doughnut_data = [{
            data: monthly_location_sales_result_sales,
            backgroundColor: [
                "#4b77a9",
                "#5f255f",
                "#d21243",
                "#B27200",
                "green",
                "burlywood",
                "blue",
                "orange",
                "red",
                "violet",

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

        var location_total_sales = document.getElementById("location_total_sales").getContext('2d');
        var doughnut_chart = new Chart(location_total_sales, {
            type: 'doughnut',
            data: {
                labels: monthly_location_sales_result_location,
                datasets: doughnut_data
            },
            options: options,
            plugins: [ChartDataLabels],
        });
    </script>
    </body>

    </html>
@endsection
