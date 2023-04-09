@extends('layouts.master')
@section('title', 'VS Report')
@section('navbar')
@section('sidebar')
@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING INVENTORY LEDGER</h3>
            </div>
            <div class="card-body">
                <form id="van_selling_report_date_range_generate_data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Salesman:</label>
                                <select class="form-control select2bs4" name="customer_id" style="width:100%;" required>
                                    <option value="" default>SELECT SALESMAN</option>
                                    @foreach ($customer as $data)
                                        <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="van_selling_report_show_input_page"></div>
                        </div>
                        <div class="col-md-12">
                            <label>&nbsp;</label>
                            <button type="submit" id="generate"
                                class="btn btn-success btn-sm float-right">Generate</button>
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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">REPORT DATA</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="van_selling_report_date_range_generate_data_page"></div>
                            <div id="van_selling_report_date_range_transfer_inventor_from_agent_to_agent_page"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div id="van_selling_report_date_range_itemized_page"></div>
                    </div>
                </div>
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

        $("#van_selling_report_date_range_generate_data").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "van_selling_report_date_range_generate_data",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data == 'no_data_found') {
                        $('#loader').hide();
                        Swal.fire(
                            'NO DATA FOUND!',
                            'CANNOT PROCEED!',
                            'error'
                        )
                       
                    } else {
                        $('#van_selling_report_date_range_generate_data_page').html(data);
                        $('#van_selling_report_date_range_itemized_page').hide();
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
