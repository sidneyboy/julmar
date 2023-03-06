@extends('layouts.master')
@section('title', 'Sku Ledger')
@section('navbar')
@section('sidebar')
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold">SKU INVENTORY LEDGER</h3>
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
                <form id="search_sku_ledger">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date - as of:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="reservation" required
                                        name="date_as_of">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Principal</label>
                            <select name="principal_id" class="form-control" required>
                                <option value="" default>Select</option>
                                @foreach ($sku_principal as $data)
                                    <option value="{{ $data->id }}">{{ $data->principal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SKU Type:</label>
                                <select class="form-control select2bs4" name="sku_type" required style="width:100%;">
                                    <option value="" default>Select</option>
                                    <option value="Case">Case</option>
                                    <option value="Butal">Butal</option>
                                    <option value="all">All</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-sm btn-info float-right" type="submit">Generate SKU Ledger</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold">DATA</h3>
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
                <div class="row">
                    <div class="col-md-12">
                        <div id="show_data"></div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
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

        $("#search_sku_ledger").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            $.ajax({
                url: "search_inventory_ledger",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data == 'no_data') {
                        Swal.fire(
                            'ERROR INPUT',
                            'NO DATA',
                            'error'
                        );
                        $('.loading').hide();
                    } else {
                        $('.loading').hide();
                        $('#show_data').html(data);
                    }
                },
            });
        }));
    </script>
    </body>

    </html>
@endsection
