@extends('layouts.master')
@section('title', 'SALES INVOICE PRINT')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SALES INVOICE PRINT</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('sales_invoice_generate') }}" target="_blank" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label>Sales Invoice</label>
                            <select name="sales_invoice_id" style="width:100%;" class="form-control select2" required>
                                <option value="" default>Select</option>
                                @foreach ($sales_invoice as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->agent->full_name . ' - ' . $data->principal->principal . ' - ' . $data->delivery_receipt ." - ". $data->total }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn btn-info btn-block" type="submit">PROCEED</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="sales_invoice_generate_page"></div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->


        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">Calculated Summary</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="sales_order_draft_proceed_to_final_summary_page"></div>
                        </div>
                    </div>
                </div>
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






        // $("#sales_invoice_generate").on('submit', (function(e) {
        //     e.preventDefault();
        //     //$('.loading').show();
        //     // $('#sales_order_migrate_summary_page').show();
        //     $.ajax({
        //         url: "sales_invoice_generate",
        //         type: "POST",
        //         data: new FormData(this),
        //         contentType: false,
        //         cache: false,
        //         processData: false,
        //         success: function(data) {
        //             $('.loading').hide();
        //         },
        //     });
        // }));
    </script>
    </body>

    </html>
@endsection
