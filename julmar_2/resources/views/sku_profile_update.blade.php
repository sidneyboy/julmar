@extends('layouts.master')
@section('title', 'SKU PROFILE UPDATE')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SKU PROFILE UPDATE</h3>
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
                <form id="sku_profile_update_generate_sku">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Principal:</label>
                                <select required name="sku_principal_id" class="form-control select2" style="width:100%;">
                                    <option value="" default>Select</option>
                                    @foreach ($principal as $data)
                                        <option value="{{ $data->id }}">{{ $data->principal }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Sku Type:</label>
                            <select name="sku_type" class="form-control select2" style="width:100%;" required>
                                <option value="" default>Select</option>
                                <option value="BUTAL">Butal</option>
                                <option value="CASE">Case</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button type="submit" class="btn btn-info btn-block">Generate Sku</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="sku_profile_update_generate_sku_page"></div>
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
