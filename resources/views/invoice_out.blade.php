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
                <h3 class="card-title" style="font-weight: bold;">INVOICE OUT</h3>
            </div>

            <div class="card-body">
                <form id="invoice_out_proceed">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Delivery Receipt/Sales Rep:</label>
                            <select class="form-control select2bs4" style="width:100%;" required
                                name="sales_representative">
                                <option value="" default>Select</option>
                                @foreach ($invoice_draft as $data)
                                    <option value="{{ 'booking-' . $data->sales_representative }}">
                                        {{ $data->sales_representative }}
                                    </option>
                                @endforeach
                                @foreach ($van_selling as $vs)
                                    <option value="{{ 'van-' . $vs->id }}">{{ $vs->delivery_receipt }}</option>
                                @endforeach
                                @foreach ($sales_invoice as $sales_invoice_data)
                                    <option value="{{ 'agent_booking-' . $sales_invoice_data->id }}">{{ $sales_invoice_data->delivery_receipt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div id="invoice_out_page"></div>
            </div>

        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SUMMARY</h3>
            </div>
            <div class="card-body">
                <div id="invoice_out_final_summary_page"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">FINAL SUMMARY</h3>
            </div>
            <div class="card-body">
                <div id="invoice_out_very_final_summary_page"></div>
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


        $("#invoice_out_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "invoice_out_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    if (data == 'wrong_sku') {
                        Swal.fire(
                            'Cannot Proceed',
                            'Wrong SKU Scanned',
                            'error'
                        )

                        $('#loader').hide();
                    } else if (data == 'existing') {
                        Swal.fire(
                            'Cannot Proceed',
                            'SKU Already Scanned',
                            'error'
                        )

                        $('#loader').hide();
                    } else if (data == 'Non Existing SKU Barcode') {
                        Swal.fire(
                            'Cannot Proceed',
                            'Invalid Barcode',
                            'error'
                        )

                        $('#loader').hide();
                    } else if (data == 'Sku Not in the PO') {
                        Swal.fire(
                            'Cannot Proceed',
                            'Scanned SKU Cannot be found in PO or SKU already received',
                            'error'
                        )

                        $('#loader').hide();
                    } else {
                        $('#invoice_out_page').html(data);
                        $('#barcode').val('');
                        $('#barcode').focus();
                        $('#loader').hide();
                    }
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
