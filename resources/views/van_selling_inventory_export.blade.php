@extends('layouts.master')
@section('title', 'VS EXPORT AND PRINT')
@section('navbar')
@section('sidebar')
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING INVENTORY EXPORT AND PRINT</h3>
            </div>
            <div class="card-body">
                <form id="van_selling_inventory_export_generate_data">
                    <div class="row">
                        <div class="col-md-6">
                            <label>SELECT VAN SELLING AGENT</label>
                            <select class="form-control select2bs4" name="customer_id" required style="width:100%;">
                                <option value="" default>SELECT</option>
                                @foreach ($customer as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->store_name . ' - [' . $data->location->location . ']' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>SEARCH FOR:</label>
                            <select class="form-control select2bs4" name="search_for" required style="width:100%;">
                                <option value="" default>SEARCH FOR</option>
                                {{-- <option value="van_load_export">NEW VAN LOAD EXPORT</option>
               <option value="inventory_adjustment_export">INVENTORY ADJUSTMENT EXPORT(EVERY CUT OFF)</option> --}}
                                <option value="admin_export" selected>ADMIN EXPORT</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn btn-info btn-sm float-right" type="submit">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="van_selling_inventory_export_generate_data_page"></div>
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

        $("#van_selling_inventory_export_generate_data").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "van_selling_inventory_export_generate_data",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {

                    if (data == 'NO_DATA_FOUND') {
                        $('#loader').hide();
                        Swal.fire(
                            'CANNOT PROCEED',
                            'NOTHING TO BE EXPORTED',
                            'error'
                        )

                    } else {
                        $('#van_selling_inventory_export_generate_data_page').html(data);
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
