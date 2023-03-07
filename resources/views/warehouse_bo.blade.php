@extends('layouts.master')
@section('title', 'Walk In SO')
@section('navbar')
@section('sidebar')
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">BAD ORDER</h3>
            </div>
            <div class="card-body">
                <form id="warehouse_bo_proceed">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Barcode</label>
                            <input type="text" class="form-control" required name="barcode" autofocus
                                placeholder="SKU Barcode" id="barcode">
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn btn-sm float-right btn-info">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div id="warehouse_bo_proceed_page"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" style="font-weight: bold">FINAL SUMMARY</div>
            <div class="card-body">
                <div id="warehouse_bo_final_summary_page"></div>
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


        $("#warehouse_bo_proceed").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            $('#hide_if_trigger').hide();
            $.ajax({
                url: "warehouse_bo_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data == 'No Data Found!') {
                        Swal.fire(
                            'Cannot Proceed',
                            'No Data Found!',
                            'error'
                        )
                    } else {
                        $('#warehouse_bo_proceed_page').html(data);
                    }
                },
                error: function(error) {
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
