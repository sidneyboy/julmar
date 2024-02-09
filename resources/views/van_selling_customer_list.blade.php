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
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING CUSTOMER LIST</h3>
            </div>
            <div class="card-body">
                <form id="van_selling_customer_list_show_data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Location</label>
                            <select name="location_id" class="form-control" required>
                                <option value="" default>Select</option>
                                @foreach ($location as $data)
                                    <option value="{{ $data->id }}">{{ $data->location }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <button class="btn btn-sm float-right btn-info">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="van_selling_customer_list_show_data_page"></div>
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


        $("#van_selling_customer_list_show_data").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $('#hide_if_trigger').hide();
            $.ajax({
                url: "van_selling_customer_list_show_data",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    $('#van_selling_customer_list_show_data_page').html(data);
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
