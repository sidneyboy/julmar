@extends('layouts.master')
@section('title', 'SUB CATEGORY')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">NEW SKU SUB CATEGORY</h3>
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
                @if ($message = Session::get('error'))
                    <div class="alert alert-error" id="error-alert">
                        {{ $message }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Main Category</label>
                        <select name="main_category_id" class="form-control select2" required>
                            <option value="" default>Select</option>
                            @foreach ($main_category as $data)
                                <option value="{{ $data->id }}">{{ $data->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">Sub Category</label>
                        <input type="text" class="form-control" required name="sub_category">
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
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



        $("#sku_profile_update_generate_sku").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            $.ajax({
                url: "sku_profile_update_generate_sku",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    //$('.loading').hide();
                    $('#sku_profile_update_generate_sku_page').html(data);
                },
            });
        }));
    </script>
    </body>

    </html>
@endsection
