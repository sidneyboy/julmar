@extends('layouts.master')
@section('title', 'VS Withdrawal')
@section('navbar')
@section('sidebar')
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING WITHDRAWAL</h3>
            </div>
            <div class="card-body">
                <form id="van_selling_generate_sku_quantity" enctype="multipart/form-data" method="post">
                    @csrf
                    <p style="color:blue;">NOTE: PALIHOG CHECK SA VS AR LEDGER KONG NAA NABA SIYA BEGINNING BEFORE MAG IN SA
                        IYANG INVENTORY AND NEW
                        VANLOADS SALAMAT</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Location:</label>
                                <select class="form-control select2bs4" required name="location_id" id="location_id"
                                    style="width:100%;">
                                    <option value="" default>SELECT LOCATION</option>
                                    @foreach ($location as $data)
                                        <option value="{{ $data->id }}">{{ $data->location }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sku Type:</label>
                                <select class="form-control select2bs4" required name="sku_type" id="sku_type"
                                    style="width:100%;">
                                    <option value="" default>SELECT SKU TYPE</option>
                                    <option value="Butal">Butal</option>
                                    <option value="Case">Case</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Principal:</label>
                                <select class="form-control select2bs4" required name="principal" id="principal"
                                    style="width:100%;">
                                    <option value="" default>SELECT PRINCIPAL</option>
                                    @foreach ($principal as $data)
                                        <option value="{{ $data->id }}">{{ $data->principal }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="van_selling_generate_sku_page"></div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SKU QUANTITY INPUT </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="van_selling_generate_sku_quantity_page"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
            <!-- /.card-footer-->
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING FINAL SUMMARY </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="van_selling_generate_final_summary_page"></div>
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



        $("#principal").on('change', (function(e) {
            e.preventDefault();
            $('#loader').show();
            var principal = $('#principal').val();
            var location_id = $('#location_id').val();
            var sku_type = $('#sku_type').val();
            $.ajax({
                url: "van_selling_generate_sku",
                type: "POST",
                data: 'principal=' + principal + '&location_id=' + location_id + '&sku_type=' +
                    sku_type,
                success: function(data) {
                    if (data == 'no_location') {
                        $('#loader').hide();
                        Swal.fire(
                            'INPUT ERROR',
                            'PLEASE SELECT LOCATION AND SKU TYPE',
                            'error'
                        );

                    } else {
                        $('#loader').hide();
                        $('#van_selling_generate_sku_page').html(data);
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

        $("#van_selling_generate_sku_quantity").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "van_selling_generate_sku_quantity",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data == 'no_customer_principal_code_and_price') {
                        $('#loader').hide();
                        Swal.fire(
                            'PALIHOG BUTANGI SA DAAN OG PRINCIPAL CODE AND PRICE',
                            '',
                            'error'
                        );

                    } else if (data == 'no_beginning_ar_ledger') {
                        $('#loader').hide();
                        Swal.fire(
                            'PALIHOG INPUT DAAN SA IYANG BEGINNING AR BALANCE. DAKONG SALAMAT',
                            '',
                            'error'
                        );

                    } else {
                        $('#loader').hide();
                        $('#quantity').val('');
                        $("#sku").val('').trigger('change');
                        $('#van_selling_generate_sku_quantity_page').html(data);
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
