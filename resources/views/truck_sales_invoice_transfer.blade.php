@extends('layouts.master')
@section('title', 'Walk In SO')
@section('navbar')
@section('sidebar')
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">TRUCK LOAD INVOICE TRANSFER</h3>
            </div>
            <div class="card-body">
                <form id="truck_sales_invoice_transfer_proceed">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label>SELECT LOADSHEET</label>
                            <select name="logistics_id" id="logistics_id" class="form-control select2bs4"
                                style="width:100%;" required>
                                <option value="" default>SELECT LOAD SHEET</option>
                                @foreach ($logistics as $data)
                                    <option value="{{ $data->id }}">
                                        LOAD SHEET - {{ $data->id . ' - ' . $data->load_sheet_driver->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div id="truck_sales_invoice_transfer_generate_invoice_page"></div>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div id="truck_sales_invoice_transfer_proceed_page"></div>
            </div>
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


        $("#logistics_id").change(function() {
            $('#loader').show();
            var logistics_id = $(this).val();
            $.post({
                type: "POST",
                url: "/truck_sales_invoice_transfer_generate_invoice",
                data: 'logistics_id=' + logistics_id,
                success: function(data) {
                    $('#loader').hide();
                    $('#truck_sales_invoice_transfer_generate_invoice_page').html(data);
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
        });


        $("#truck_sales_invoice_transfer_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "truck_sales_invoice_transfer_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    $('#truck_sales_invoice_transfer_proceed_page').html(data);
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
