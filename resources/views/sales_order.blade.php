@extends('layouts.master')
@section('title', 'SALES ORDER UPLOAD')
@section('navbar')
@section('sidebar')
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SALES ORDER UPLOAD</h3>
            </div>
            <div class="card-body">
                <form id="uploadForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <input type="file" name="agent_csv_file" accept=".csv" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-sm float-right btn-info">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="sales_order_upload_page"></div>
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

        $("#uploadForm").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            $.ajax({
                url: "sales_order_upload",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data == 'saved') {
                        $('#loader').hide();
                        Swal.fire(
                            'Work Submitted',
                            '',
                            'success'
                        )
                        location.reload();
                    } else if (data == 'file_already_uploaded') {
                        $('#loader').hide();
                        Swal.fire(
                            'ERROR INPUT',
                            'FILE ALREADY UPLOADED',
                            'error'
                        )
                    } else if (data == 'incorrect_file_uploaded') {
                        $('#loader').hide();
                        Swal.fire(
                            'ERROR INPUT',
                            'INCORRECT FILE',
                            'error'
                        )
                    }
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
