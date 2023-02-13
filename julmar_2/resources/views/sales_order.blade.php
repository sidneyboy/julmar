@extends('layouts.master')
@section('title', 'SALES ORDER UPLOAD')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SALES ORDER UPLOAD</h3>
            </div>
            <div class="card-body">
                <form action="sales_order_upload" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <input type="file" name="agent_csv_file" accept=".csv" required class="form-control">

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" value="SALES ORDER UPLOAD" id="upload_agent_sales_order"
                                    class="btn btn-block btn-success" />
                            </div>
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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">Generated Summary</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @if ($message = Session::get('file_already_uploaded'))
                            <div class="alert alert-danger" id="success-alert">
                              <strong>Error! </strong> Existing File.
                          </div>
                        @endif

                        @if ($message = Session::get('incorrect_file_uploaded'))
                            <div class="alert alert-danger" id="success-alert">
                              <strong>Error! </strong> Incorrect File.
                          </div>
                        @endif

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success" id="success-alert">
                              <strong>Success! </strong> Data Uploaded.
                          </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="sales_order_proceed_to_summary_page"></div>
                        </div>
                    </div>
                </div>
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

        // $("#uploadForm").on('submit', (function(e) {
        //     e.preventDefault();
        //     //$('.loading').show();
        //     $.ajax({
        //         url: "sales_order_upload",
        //         type: "POST",
        //         data: new FormData(this),
        //         contentType: false,
        //         cache: false,
        //         processData: false,
        //         success: function(data) {

        //           if (data == 'file_already_uploaded') {
        //             alert('asdasd');
        //           }

        //             // if (data == "saved") {
        //             //     alert('saved');
        //             // } else if (data == 'file_already_uploaded') {
        //             //     Swal.fire(
        //             //         'ERROR INPUT',
        //             //         'FILE ALREADY UPLOADED',
        //             //         'error'
        //             //     )
        //             //     $('.loading').hide();
        //             // } else if (data == 'incorrect_file_uploaded') {
        //             //   alert('asdasd');
        //             // }

        //             // if(data = "file_already_uploaded"){
        //             //   Swal.fire(
        //             //   'ERROR INPUT',
        //             //   'FILE ALREADY UPLOADED',
        //             //   'error'
        //             //   )
        //             //   $('.loading').hide(); 
        //             // }else if(data = "incorrect_file_uploaded"){
        //             //   Swal.fire(
        //             //   'ERROR INPUT',
        //             //   'INCORRECT FILE UPLOADED',
        //             //   'error'
        //             //   )
        //             //   $('.loading').hide(); 
        //             // }else if(data = "saved"){
        //             //   $('.loading').hide(); 
        //             //   Swal.fire(
        //             //   'Work Submitted',
        //             //   '',
        //             //   'success'
        //             //   )
        //             //   location.reload();
        //             //   $('.loading').hide();
        //             // }












        //         },
        //     });
        // }));
    </script>
    </body>

    </html>
@endsection
