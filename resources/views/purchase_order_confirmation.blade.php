@extends('layouts.master')

@section('title', 'Purchase Order')

@section('navbar')


@section('sidebar')


@section('content')

    <!-- Main content -->
    <section class="content">


        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold">PURCHASE ORDER CONFIRMATION</h3>
            </div>
            <div class="card-body">
                <form id="purchase_order_confirmation_proceed">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Purchase Order #</label>
                            <select name="purchase_id" class="form-control select2bs4" style="width:100%;" required>
                                <option value="" default>Select</option>
                                @foreach ($purchase_order as $data)
                                    <option value="{{ $data->id }}">{{ $data->purchase_id . '-' . $data->sku_type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn btn-sm float-right btn-info">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="purchase_order_confirmation_proceed_page"></div>
            </div>
            <!-- /.card-footer-->
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold">FINAL SUMMARY</h3>
            </div>
            <div class="card-body">
                <div id="purchase_order_confirmation_final_summary_page"></div>
            </div>
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

        $("#purchase_order_confirmation_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "purchase_order_confirmation_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#purchase_order_confirmation_proceed_page').html(data);
                    $('#loader').hide();
                },
                error: function(error) {
                    Swal.fire(
                        'Cannot Proceed',
                        'Please Contact IT Support',
                        'error'
                    )
                    $('#loader').hide();
                }
            });
        }));
    </script>
    </body>

    </html>
@endsection
