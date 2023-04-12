@extends('layouts.master')
@section('title', 'Receive Order')
@section('navbar')
@section('sidebar')
@section('content')

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">RECEIVING SECTION(DRAFT)</h3>
            </div>
            <div class="card-body">
                <form id="receiving_draft_proceed">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <a class="btn btn-sm float-right btn-dark" id="scan_barcode" style="display:none">SCAN
                                BARCODE</a>
                            <a class="btn btn-sm float-right btn-warning" id="select_sku">SELECT SKU</a>
                        </div>
                        <div class="col-md-6">
                            <label for="">Purchase Order/Van #</label>
                            <select name="purchase_id" class="form-control" id="purchase_id" required>
                                <option value="" default>Select</option>
                                @foreach ($purchase_order as $data)
                                    <option value="{{ $data->id }}">{{ $data->purchase_id }}/{{ $data->van_number }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="session_id" value="{{ $session_id }}">
                        </div>
                        <div class="col-md-6" id="scan_barcode_div">
                            <label for="">Scan Barcode</label>
                            <input type="text" class="form-control" name="barcode" id="barcode">
                        </div>
                        <div class="col-md-6" id="select_sku_div" style="display: none">
                            <div id="show_sku_selection"></div>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div id="show_draft"></div>
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

        $("#select_sku").click(function() {
            $('.loading').show();
            $('#scan_barcode_div').hide();
            $('#barcode').val('');
            var purchase_id = $('#purchase_id').val();
            $.post({
                type: "POST",
                url: "/receiving_draft_sku_selection",
                data: 'purchase_id=' + purchase_id,
                success: function(data) {
                    $('#loader').hide();
                    $('#select_sku').hide()
                    $('#scan_barcode').show()
                    $('#select_sku_div').show();
                    $('#show_sku_selection').html(data);
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

        $("#scan_barcode").click(function() {
            $('.loading').show();
            $('#select_sku_div').hide();
            $('#select_sku').show()
            $('#scan_barcode').hide()
            $("#sku_barcode").val('').trigger('change');
            $('#scan_barcode_div').show();
        });



        $("#receiving_draft_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "receiving_draft_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#barcode').val('');
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
                    } else if (data == 'sku_received') {
                        Swal.fire(
                            'Cannot Proceed',
                            'SKU Already Received!',
                            'error'
                        )
                        $('#loader').hide();
                    } else {
                        $('#show_draft').html(data);
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
