@extends('layouts.master')

@section('title', 'Transfer To Branch Report')

@section('navbar')


@section('sidebar')


@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SKU MANUAL WITHDRAWAL</h3>

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
                <form id="sku_withdrawal_proceed">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Principal</label>
                            <select name="principal_id" class="form-control" required>
                                <option value="" default>Select</option>
                                @foreach ($principal as $data)
                                    <option value="{{ $data->id }}">{{ $data->principal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">SKU Type</label>
                            <select name="sku_type" class="form-control" required>
                                <option value="" default>Select</option>
                                <option value="Case">Case</option>
                                <option value="Butal">Butal</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Price Level</label>
                            <select name="price_level" class="form-control" required>
                                <option value="" default>Select</option>
                                <option value="price_1">Price 1</option>
                                <option value="price_2">Price 2</option>
                                <option value="price_3">Price 3</option>
                                <option value="price_4">Price 4</option>
                                <option value="price_5">Price 5</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn btn-sm float-right btn-info">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="sku_withdrawal_proceed_page"></div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">PRE SUMMARY</h3>
            </div>
            <div class="card-body">
                <div id="sku_withdrawal_final_summary_page"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">FINAL SUMMARY</h3>
            </div>
            <div class="card-body">
                <div id="sku_withdrawal_very_final_summary_page"></div>
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

        $("#sku_withdrawal_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $('#hide_if_trigger').hide();
            $.ajax({
                url: "sku_withdrawal_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#sku_withdrawal_proceed_page').html(data);
                    $('#loader').hide();
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
