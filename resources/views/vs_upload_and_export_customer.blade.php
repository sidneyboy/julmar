@extends('layouts.master')
@section('title', 'VAN SELLING')
@section('navbar')
@section('sidebar')
@section('content')
    
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING CUSTOMERS</h3>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form id="vs_upload_and_export_proceed">
                    <div class="row">
                        <div class="col-md-12">
                            <label>To Do:</label>
                            <select name="to_do" class="form-control" id="to_do" style="width:100%" required>
                                <option value="" default>Select</option>
                                <option value="Extract Customer">Extract Customer</option>
                                <option value="Upload Customer">Upload Customer</option>
                            </select>
                        </div>
                        <div class="col-md-12" style="width:100%;display:none;" id="location_id">
                            <label>Location:</label>
                            <select name="location_id" class="form-control" >
                                <option value="" default>Select Location</option>
                                @foreach ($location as $data)
                                    <option value="{{ $data->id }}">{{ $data->location }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button type="submit" id="proceed" class="btn btn-info btn-sm float-right">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="vs_upload_and_export_proceed_page"></div>
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

        $("#to_do").change(function() {
            if ($(this).val() == 'Extract Customer') {
                $('#location_id').show();
            }else{
                $('#location_id').hide();
            }
        });

        $("#vs_upload_and_export_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('.loading').show();
            $.ajax({
                url: "vs_upload_and_export_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#vs_upload_and_export_proceed_page').html(data);
                    // $('#proceed').hide();
                    $('.loading').hide();
                },
            });
        }));
    </script>
    </body>

    </html>
@endsection
