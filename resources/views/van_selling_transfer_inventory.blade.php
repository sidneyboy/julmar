@extends('layouts.master')
@section('title', 'VS Transfer Inventory')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING TRANSFER INVENTORY</h3>
            </div>
            <div class="card-body">
                <form id="van_selling_transfer_inventory_proceed">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label>Transfer From:</label>
                            <select name="transfer_from" class="form-control select2" required style="width:100%;">
                                <option value="" default>SELECT</option>
                                @foreach ($van_selling_transfer as $data)
                                    <option
                                        value="{{ $data->id . '-' . $data->customer_id . '-' . $data->customer->store_name . '-' . $data->transfered_amount }}">
                                        {{ $data->customer->store_name . ' - ' . number_format($data->transfered_amount, 2, '.', ',') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Transfer To:</label>
                            <select name="transfer_to" class="form-control select2" required style="width:100%;">
                                <option value="" default>SELECT</option>
                                @foreach ($customer as $data)
                                    <option value="{{ $data->id . '-' . $data->store_name }}">{{ $data->store_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="">Remarks:</label>
                            <textarea name="remarks" class="form-control" id="" cols="30" rows="3"></textarea>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button type="submit" class="btn btn-block btn-info">PROCEED</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="van_selling_transfer_inventory_proceed_page"></div>
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

        $("#van_selling_transfer_inventory_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('.loading').show();
            $.ajax({
                url: "van_selling_transfer_inventory_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data == 'same_customer_id') {
                        Swal.fire(
                            'CANNOT TRANSFER SAME AGENT INVENTORY',
                            'CANNOT PROCEED!',
                            'error'
                        )
                        $('.loading').hide();
                    } else {
                        $('#van_selling_transfer_inventory_proceed_page').html(data);
                        $('.loading').hide();
                    }

                },
            });
        }));
    </script>
    </body>

    </html>
@endsection
