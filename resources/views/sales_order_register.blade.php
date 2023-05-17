@extends('layouts.master')
@section('title', 'Sales Order Register')
@section('navbar')
@section('sidebar')
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">AGENT SALES ORDER</h3>
            </div>
            <div class="card-body">
                <form id="sales_order_register_generate_sales_register" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        {{-- <div class="col-md-4">
                            <label>Date Range:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right" id="reservation" name="date_range"
                                    required>
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <label>Agent:</label>
                            <select class="form-control select2bs4" name="agent_id" id="agent_id" style="width:100%;">
                                <option value="" default>SELECT AGENT</option>
                                @foreach ($agent as $data)
                                    <option value="{{ $data->id }}">{{ $data->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div id="sales_order_register_show_next_input_page"></div>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button type="submit" id="generate_button" style="display: none;"
                                class="btn btn-info btn-sm float-right">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="sales_order_register_generate_sales_register_page"></div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SALES ORDER DETAILED REPORT</h3>
            </div>
            <div class="card-body">
                <div id="sales_order_register_view_details"></div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
            <!-- /.card-footer-->
        </div>


    </section>
    <!-- /.content -->
@endsection
@section('footer')
    @parent
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#agent_id").on('change', (function(e) {
            e.preventDefault();
            // $('#loader').show();
            $('#generate_button').show();
            var agent_id = $(this).val();
            var date_range = $('#reservation').val();
            $.ajax({
                url: "sales_order_register_show_next_input",
                type: "POST",
                data: 'agent_id=' + agent_id + '&date_range=' + date_range,
                success: function(data) {
                    console.log(data);
                    $('#loader').hide();
                    $('#sales_order_register_show_next_input_page').html(data);
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

        $("#sales_order_register_generate_sales_register").on('submit', (function(e) {
            e.preventDefault();
            // $('#loader').show();
            $.ajax({
                url: "sales_order_register_generate_sales_register",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    $('#sales_order_register_generate_sales_register_page').html(data);
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
