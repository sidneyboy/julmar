@extends('layouts.master')
@section('navbar')
@section('sidebar')
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">NEW SKU DATA</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <form id="sku_add_proceed" accept-charset="utf-8">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if (session('success'))
                                <div class="alert alert-success border-left-success alert-dismissible fade show"
                                    role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger border-left-danger alert-dismissible fade show"
                                    role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Principal:</label>
                                <select required name="principal_id" id="principal_id" class="form-control select2bs4"
                                    style="width:100%;">
                                    <option value="" default>Select Sku Principal</option>
                                    @foreach ($principals as $principal)
                                        <option value="{{ $principal->id }}">{{ $principal->principal }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="sku_show_main_category">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sku Type:</label>
                                <select required name="sku_type" style="width:100%;" id="sku_type"
                                    class="form-control select2bs4">
                                    <option value="" default>Select Sku Type</option>
                                    <option value="Case">Case</option>
                                    <option value="Butal">Butal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Sku Description:</label>
                                <input required type="text" class="form-control" name="description" autofocus>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sku Code:</label>
                                <input required type="text" class="form-control" name="sku_code">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Barcode:</label>
                                <input type="text" class="form-control" required name="barcode">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-sm btn-info float-right" type="submit">Proceed</button>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SKU DETAILS</h3>
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
                <div id="sku_show_details"></div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
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
        $("#principal_id").change(function() {
            var principal_id = $(this).val();
            $.post({
                type: "POST",
                url: "/sku_show_main_category",
                data: 'principal_id=' + principal_id,
                success: function(data) {
                    console.log(data);
                    $('#sku_show_main_category').html(data);
                    $('.loading').hide();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
        $("#sku_add_proceed").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            $('#hide_if_trigger').hide();
            $.ajax({
                url: "sku_show_details",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    // $('.loading').hide();
                    // $("#principal").val('').trigger('change');
                    // $('#van_selling_transaction_show_sku_page').hide();
                    $('#sku_show_details').html(data);
                    // $('#hide_if_trigger').show();
                },
            });
        }));
    </script>
    </body>

    </html>
@endsection
