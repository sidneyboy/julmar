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
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Agent</label>
                            <select name="agent_id" id="agent_id" class="form-control select2bs4" style="width:100%;"
                                required>
                                <option value="" default>Select</option>
                                @foreach ($agent as $agent_data)
                                    <option value="{{ $agent_data->id }}">{{ $agent_data->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div id="booking_pcm_show_invoice_page"></div>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn float-right btn-sm btn-info" type="submit">Proceed</button>
                        </div>
                    </div>
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

        $("#agent_id").change(function() {
            var agent_id = $('#agent_id').val();
            $.post({
                type: "POST",
                url: "/booking_pcm_show_invoice",
                data: 'agent_id=' + agent_id,
                success: function(data) {
                    $('.loading').hide();
                    $('#booking_pcm_show_invoice_page').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>
    </body>

    </html>
@endsection
