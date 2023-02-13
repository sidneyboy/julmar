@extends('layouts.master')
@section('title', 'Sales Control')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SALES CONTROL</h3>
            </div>
            <div class="card-body">
                <form id="sales_invoice_control_proceed">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control select2" style="width:100%;" required name="principal_id">
                                <option value="" default>Select Principal</option>
                                @foreach ($principal as $data)
                                    <option value="{{ $data->id }}">{{ $data->principal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select2" style="width:100%;" required name="agent_id">
                                <option value="" default>Select Agent</option>
                                @foreach ($agent as $data)
                                    <option value="{{ $data->id }}">{{ $data->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select2" style="width:100%;" required name="sku_type">
                                <option value="" default>Select Sku Type</option>
                                <option value="Case">Case</option>
                                <option value="Butal">Butal</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select2" style="width:100%;" required name="control_option">
                                <option value="" default>Select Control Type</option>
                                <option value="new_control">Print New Control</option>
                                <option value="old_control">Print Old Control</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-info btn-block">GENERATE AGENT SALES CONTROL</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="sales_invoice_control_proceed_page"></div>
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



        $("#sales_invoice_control_proceed").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();

            $.ajax({
                url: "sales_invoice_control_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {


                    console.log(data);

                    if (data == 'no_data_found') {
                        Swal.fire(
                            'ERROR INPUT',
                            'NO DATA FOUND',
                            'error'
                        )
                        $('#sales_invoice_control_proceed_page').hide();
                        $('.loading').hide();
                    } else {
                        $('.loading').hide();
                        $('#sales_invoice_control_proceed_page').html(data);
                    }

                },
            });
        }));
    </script>
    </body>

    </html>
@endsection
