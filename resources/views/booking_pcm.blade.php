@extends('layouts.master')

@section('title', 'Bodega Out')

@section('navbar')


@section('sidebar')


@section('content')

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">BOOKING PCM FOR DRIVER</h3>
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
                <form id="booking_pcm_proceed">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">PCM Type:</label>
                            <select name="pcm_type" class="form-control" required style="width:100%;">
                                <option value="" default>Select</option>
                                <option value="RGS">RGS</option>
                                {{-- <option value="BO">BO</option> --}}
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">SKU Type:</label>
                            <select name="sku_type" class="form-control" required>
                                <option value="" default>Select</option>
                                <option value="Butal">Butal</option>
                                <option value="Case">Case</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Principal:</label>
                            <select name="principal_id" class="form-control" required style="width:100%;">
                                <option value="" default>Select</option>
                                @foreach ($principal as $data)
                                    <option value="{{ $data->id }}">{{ $data->principal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Customer:</label>
                            <select name="customer_id" class="form-control select2bs4" required style="width:100%;">
                                <option value="" default>Select</option>
                                @foreach ($customer as $data)
                                    <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br />
                    <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
                </form>
            </div>
            <div class="card-footer">
                <div id="booking_pcm_proceed_page"></div>
            </div>
        </div>

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
                <div id="booking_pcm_proceed_final_summary_page"></div>
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

        $("#booking_pcm_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $('#hide_if_trigger').hide();
            $.ajax({
                url: "booking_pcm_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#booking_pcm_proceed_page').html(data);
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
