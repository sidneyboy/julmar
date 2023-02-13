@extends('layouts.master')
@section('navbar')
@section('sidebar')
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SKU BARCODE</h3>
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
                        @if (session('success'))
                            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <label for="">Principal</label>
                        <select name="principal_id" id="principal_id" class="form-control" required>
                            <option value="" default>Select</option>
                            @foreach ($principals as $data)
                                <option value="{{ $data->id }}">{{ $data->principal }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="show_sku"></div>
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

        $("#principal_id").change(function() {
            var principal_id = $('#principal_id').val();
            $.post({
                type: "POST",
                url: "/sku_barcode_show_sku",
                data: 'principal_id=' + principal_id,
                success: function(data) {
                    console.log(data);
                    $('#show_sku').html(data);
                    $('.loading').hide();
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
