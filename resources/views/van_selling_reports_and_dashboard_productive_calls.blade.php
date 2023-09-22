@extends('layouts.master')
@section('navbar')
@section('sidebar')
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING TOTAL # OF PRODUCTIVE CALLS REPORT</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <form id="van_selling_reports_and_dashboard_productive_calls_generate">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" name="date_range" required
                                        id="reservation">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="location_id" class="form-control" required>
                                    <option value="" default>Select Sales Area</option>
                                    @foreach ($location as $data)
                                        <option value="{{ $data->id }}">{{ $data->location }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="customer_id" class="form-control" required>
                                    <option value="" default>Select Agent</option>
                                    @foreach ($customer as $customer_data)
                                        <option value="{{ $customer_data->id }}">{{ $customer_data->store_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button class="btn btn-block btn-info" type="submit">Generate Data</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div id="van_selling_reports_and_dashboard_productive_calls_generate_page"></div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    @parent
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        $("#van_selling_reports_and_dashboard_productive_calls_generate").on('submit', (function(e) {
            e.preventDefault();
            //$('#loader').show();
            $('#hide_if_trigger').hide();
            $.ajax({
                url: "van_selling_reports_and_dashboard_productive_calls_generate",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#van_selling_reports_and_dashboard_productive_calls_generate_page').html(
                        data);
                },
                error: function(error) {
                    $('#loader').hide();
                    Swal.fire(
                        'Cannot Proceed',
                        'Please Contact IT Support',
                        'error'
                    )
                }
            });
        }));
    </script>
    </body>

    </html>
@endsection
