@extends('layouts.master')

@section('title', 'TRUCK AND SALES INVOICES')

@section('navbar')


@section('sidebar')


@section('content')

    <br />
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">TRUCK AND SALES INVOICES</h3>

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
                <form id="truck_and_sales_invoice_generate_data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
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
                        </div>
                        <div class="col-md-6">
                            <label>Truck:</label>
                            <select name="truck_id" class="form-control select2" required style="width:100%">
                                <option value="" default>Select</option>
                                @foreach ($truck as $data)
                                    <option value="{{ $data->id }}">{{ $data->plate_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button type="submit" class="btn btn-info btn-block">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="truck_and_sales_invoice_generate_data_page"></div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

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

        $("#truck_and_sales_invoice_generate_data").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            // $('#sales_order_migrate_summary_page').show();
            $.ajax({
                url: "truck_and_sales_invoice_generate_data",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#truck_and_sales_invoice_generate_data_page').html(data);
                },
            });
        }));

        // $("#received_id").change(function() {
        //     var received_id = $(this).val();
        //     $('.loading').show();
        //     $.post({
        //         type: "POST",
        //         url: "/transfer_to_branch_show_input",
        //         data: 'received_id=' + received_id,
        //         success: function(data) {

        //             //console.log(data);
        //             $('.loading').hide();
        //             $('#show_return_inputs').html(data);

        //         },
        //         error: function(error) {
        //             console.log(error);
        //         }
        //     });
        // });
    </script>
    </body>

    </html>
@endsection
