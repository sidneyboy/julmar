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
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label>Principal</label>
                            <select class="form-control" style="width:100%;" id="principal_id" required>
                                <option value="" default>Select Principal</option>
                                @foreach ($principals as $principal)
                                    <option value="{{ $principal->id . '-' . $principal->principal }}">
                                        {{ $principal->principal }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </div>
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

        $('#principal_id').on('change', function(e) {
            var principal_id = $(this).val();
            $('.loading').show();
            $.post({
                type: "POST",
                url: "/principal_show_inputs",
                data: 'principal_id=' + principal_id,
                success: function(data) {

                    $('.loading').hide();
                    $('#reload_page').show();
                    $('#show_purcase_order_inputs').html(data);


                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        var hasSuccess = '<?php echo Session::has('not_empty'); ?>';
        if (hasSuccess) {
            toastr.warning('YOU HAVE PENDING PO!')
        }


        function reload_page() {
            $('.loading').show();
            location.reload();
        }
    </script>
    </body>

    </html>
@endsection
