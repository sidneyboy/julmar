@extends('layouts.master')
@section('title', 'SALES ORDER DRAFT')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SALES ORDER DRAFT</h3>
            </div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" id="success-alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <form id="sales_order_draft_generate" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label>Sales Order Number</label>
                            <select name="sales_order_id" style="width:100%;" class="form-control select2" required>
                                <option value="" default>Select</option>
                                @foreach ($sales_order_draft as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->agent->full_name . ' - ' . $data->principal->principal . ' - ' . $data->sales_order_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn btn-info btn-block">PROCEED</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="sales_order_draft_generate_page"></div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->


        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">Calculated Summary</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="sales_order_draft_proceed_to_final_summary_page"></div>
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






        $("#sales_order_draft_generate").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            // $('#sales_order_migrate_summary_page').show();
            $.ajax({
                url: "sales_order_draft_generate",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('.loading').hide();
                    $('#sales_order_draft_generate_page').html(data);
                },
            });
        }));
    </script>
    </body>

    </html>
@endsection
