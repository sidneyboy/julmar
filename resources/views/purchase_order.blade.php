@extends('layouts.master')

@section('title', 'Purchase Order')

@section('navbar')


@section('sidebar')


@section('content')

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold">PURCHASE ORDER</h3>

                <button class="btn btn-warning btn-flat float-right" style="display: none;" id="reload_page"
                    onclick="return reload_page()">RELOAD FOR NEW TRANSACTION</button>
            </div>
            <div class="card-body">
                <form id="principal_show_inputs">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Principal</label>
                                <select class="form-control" style="width:100%;" name="principal_id" required>
                                    <option value="" default>Select Principal</option>
                                    @foreach ($principals as $principal)
                                        <option value="{{ $principal->id }}">
                                            {{ $principal->principal }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 5px;">
                            <label for="">SKU Type</label>
                            <select name="sku_type" class="form-control" required>
                                <option value="" default>Select</option>
                                <option value="Case">Case</option>
                                <option value="Butal">Butal</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-sm float-right btn-info">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="col-md-12">
                    <div id="show_purcase_order_inputs"></div>
                </div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold">DATA</h3>
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



        $("#principal_show_inputs").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $('#hide_if_trigger').hide();
            $.ajax({
                url: "principal_show_inputs",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#show_purcase_order_inputs').html(data);
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
