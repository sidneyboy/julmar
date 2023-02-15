@extends('layouts.master')
@section('title', 'Return Report')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">RETURN TO PRINCIPAL REPORT</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservation">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" id="principal" style="width:100%;">
                                <option value="" default>Select Principal</option>
                                @foreach ($principals as $principal)
                                    <option value="{{ $principal->id . '=' . $principal->principal }}">
                                        {{ $principal->principal }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button class="btn float-right btn-sm btn-info" id="generate" style="border-radius: 0px;">Generate Report</button>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">REPORT DATA</h3>
            </div>
            <div class="card-body">
                <div id="show_return_data"></div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
            <!-- /.card-footer-->
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
        $('#generate').on('click', function(e) {
            var date = $('#reservation').val();
            var principal = $('#principal').val();
            $('.loading').show();
            $.post({
                type: "POST",
                url: "/return_to_principal_report_data",
                data: 'date=' + date + '&principal=' + principal,
                success: function(data) {

                    console.log(data);
                    $('.loading').hide();
                    $('#show_return_data').html(data);

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
