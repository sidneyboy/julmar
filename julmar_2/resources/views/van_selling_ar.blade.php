@extends('layouts.master')
@section('title', 'VS AR BEG')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING AR BEGINNING</h3>
            </div>
            <div class="card-body">
                <form id="van_selling_ar_generate" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label>Agent</label>
                            <select class="form-control select2" name="customer_id" style="width:100%;" required>
                                <option value="" default>SELECT</option>
                                @foreach ($customer as $data)
                                    <option value="{{ $data->id . ',' . $data->store_name }}">{{ $data->store_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <input type="submit" value="GENERATE" id="upload_agent_sales_order"
                                    class="btn btn-block btn-info" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="van_selling_ar_generate_page"></div>
            </div>
            <!-- /.card-footer-->
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING AR BEGINNING FINAL SUMMARY</h3>
            </div>
            <div class="card-body">
                <div id="van_selling_ar_proceed_to_final_summary_page"></div>
            </div>
            <!-- /.card-body -->
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


        $("#van_selling_ar_generate").on('submit', (function(e) {
            e.preventDefault();
            $('.loading').show();
            $.ajax({
                url: "van_selling_ar_generate",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    if (data == 'no_data_found') {
                        $('.loading').hide();
                        Swal.fire(
                            'No Data Found!!',
                            'Cannot Proceed!',
                            'error'
                        )
                    } else {
                        $('.loading').hide();
                        $('#van_selling_ar_generate_page').html(data);
                    }
                },
            });
        }));
    </script>
    </body>

    </html>
@endsection
