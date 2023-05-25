@extends('layouts.master')
@section('title', 'CUSTOMER UPLOAD')
@section('navbar')
@section('sidebar')
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">CUSTOMER UPLOAD</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                {{-- <form action="{{ route('customer_upload_process') }}" enctype="multipart/form-data" method="post"> --}}
                <form id="customer_upload_process">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <input type="file" name="agent_csv_file" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn btn-sm float-right btn-success">Upload</button>
                        </div>
                    </div>
                </form>
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


        $("#customer_upload_process").on('submit', (function(e) {
            e.preventDefault();
            //$('#loader').show();
            $.ajax({
                url: "customer_upload_process",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data = "saved") {
                        Swal.fire(
                            'Data Uploaded Successfully',
                            'Success',
                            'success'
                        )
                        $('#loader').hide();
                        location.reload();
                    } else {
                        Swal.fire(
                            'Incorrect or Existing File, Cannot Proceed!!',
                            '',
                            'error'
                        )
                        $('#loader').hide();
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
