@extends('layouts.master')
@section('title', 'CHECK/DEPOSIT SLIP')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">UPLOAD CHECK/DEPOSIT SLIP</h3>
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

                <form action="{{ route('customer_upload_check_process') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <label>Store Name</label>
                            <select name="customer_id" class="form-control select2" required>
                                <option value="" default>Select</option>
                                @foreach ($customer as $data)
                                    <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Upload Calls Data</label>
                            <input type="file" class="form-control" required name="file" accept="image/*">
                        </div>
                    </div>
                    <br />
                    <button class="btn btn-success btn-block" type="submit">UPLOAD</button>

                </form>
            </div>
            <!-- /.card-body -->
            {{-- <div class="card-footer">
                <div id="vs_upload_and_export_proceed_page"></div>
            </div> --}}
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
            } else {
                $('#location_id').hide();
            }
        });
    </script>
    </body>

    </html>
@endsection
