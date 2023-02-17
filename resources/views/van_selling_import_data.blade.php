@extends('layouts.master')
@section('title', 'VAN SELLING IMPORT')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING IMPORT</h3>
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

                <form action="{{ route('van_selling_import_data_save') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <input type="file" name="agent_csv_file" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" value="Upload" id="upload_agent_sales_order"
                                    class="btn btn-sm float-right btn-success" />
                            </div>
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


        // $("#van_selling_import_data_save").on('submit', (function(e) {
        //     e.preventDefault();
        //     $('.loading').show();
        //     $.ajax({
        //         url: "van_selling_import_data_save",
        //         type: "POST",
        //         data: new FormData(this),
        //         contentType: false,
        //         cache: false,
        //         processData: false,
        //         success: function(data) {
        //             console.log(data);
        //             if (data == 'existing_file') {
        //                 Swal.fire(
        //                     'Existing file, Cannot Proceed!!',
        //                     '',
        //                     'error'
        //                 )
        //                 $('.loading').hide();
        //             } else if (data == 'incorrect_file') {
        //                 Swal.fire(
        //                     'Incorrect_file, Cannot Proceed!!',
        //                     '',
        //                     'error'
        //                 )
        //                 $('.loading').hide();
        //             } else if (data == 'saved') {
        //                 Swal.fire(
        //                     'Data Uploaded Successfully',
        //                     'Success',
        //                     'success'
        //                 )
        //                 $('.loading').hide();
        //                 document.getElementById("van_selling_import_data_save").reset();
        //             } else {
        //                 Swal.fire(
        //                     'Incorrect_file, Cannot Proceed!!',
        //                     '',
        //                     'error'
        //                 )
        //                 $('.loading').hide();
        //             }
        //         },
        //     });
        // }));
    </script>
    </body>

    </html>
@endsection
