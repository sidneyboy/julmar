@extends('layouts.master')

@section('navbar')


@section('sidebar')


@section('content')

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">INVENTORY ADJUSTMENTS</h3>

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
                <form id="inventory_adjustments_proceed">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Principal</label>
                            <select name="principal_id" class="form-control" required>
                                <option value="" default>Select</option>
                                @foreach ($principal as $data)
                                    <option value="{{ $data->id }}">{{ $data->principal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Sku Type</label>
                            <select name="sku_type" class="form-control" required>
                                <option value="" default>Select</option>
                                <option value="Butal">Butal</option>
                                <option value="Case">Case</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn btn-sm btn-info float-right" type="submit">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="inventory_adjustments_proceed_page"></div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">FINAL SUMMARY</h3>

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
                <div id="inventory_adjustments_proceed_to_final_summary_page"></div>
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

        $("#inventory_adjustments_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $('#hide_if_trigger').hide();
            $.ajax({
                url: "inventory_adjustments_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#inventory_adjustments_proceed_page').html(data);
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
