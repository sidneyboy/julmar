@extends('layouts.master')

@section('title', 'TRUCK')

@section('navbar')


@section('sidebar')


@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">TRUCK LOAD</h3>

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
                        <label for="">Area</label>
                        <select name="location_id" id="location_id" class="form-control" required>
                            <option value="" default>Select</option>
                            @foreach ($location as $data)
                                <option value="{{ $data->id }}">{{ $data->location }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="truck_load_proceed_page"></div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;"></h3>
            </div>
            <div class="card-body">
                <div id="truck_load_generated_invoices_page"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;"></h3>
            </div>
            <div class="card-body">
                <div id="truck_load_generated_invoices_data_page"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;"></h3>
            </div>
            <div class="card-body">
                <div id="truck_load_generated_final_summary_invoices_data_page"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;"></h3>
            </div>
            <div class="card-body">
                <div id="truck_load_generated_very_final_summary_invoices_data_page"></div>
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

        $("#location_id").change(function() {
            //$('#loader').show();
            var location_id = $('#location_id').val();
            $.post({
                type: "POST",
                url: "/truck_load_proceed",
                data: 'location_id=' + location_id,
                success: function(data) {
                    $('#loader').hide();
                    $('#truck_load_proceed_page').html(data);

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
    </script>
    </body>

    </html>
@endsection
