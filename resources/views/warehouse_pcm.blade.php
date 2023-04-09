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
                <h3 class="card-title" style="font-weight: bold;">WAREHOUSE PCM</h3>
            </div>
            <div class="card-body">
                <form id="warehouse_pcm_proceed">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">PCM #</label>
                            <select name="pcm_id" class="form-control select2bs4" style="width: 100%;" required>
                                <option value="" default>Select</option>
                                @foreach ($bo as $bo_data)
                                    <option value="{{ 'bo-' . $bo_data->id }}"><span style="text-transform: uppercase">
                                            {{ $bo_data->pcm_number . '-' . $bo_data->principal->principal . '[' . $bo_data->agent->full_name . ']' }}
                                        </span></option>
                                @endforeach
                                @foreach ($rgs as $rgs_data)
                                    <option value="{{ 'rgs-' . $rgs_data->id }}"><span style="text-transform: uppercase">
                                            {{ $rgs_data->pcm_number . '-' . $rgs_data->principal->principal . '[' . $rgs_data->agent->full_name . ']' }}
                                        </span></option>
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
                <div id="warehouse_pcm_proceed_page"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" style="font-weight: bold">FINAL SUMMARY</div>
            <div class="card-body">
                <div id="warehouse_pcm_final_summary_page"></div>
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


        $("#warehouse_pcm_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "warehouse_pcm_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#warehouse_pcm_proceed_page').html(data);
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
