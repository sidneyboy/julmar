@extends('layouts.master')
@section('title', 'SALES INVOICE CONTROL')
@section('navbar')
@section('sidebar')
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SALES INVOICE CONTROL</h3>
            </div>
            <div class="card-body">
                <form id="sales_invoice_control_generate">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <select name="agent_id" class="form-control select2bs4" style="width:100%;" required>
                                    <option value="" default>SELECT AGENT</option>
                                    @foreach ($agent as $data)
                                        <option value="{{ $data->id }}">{{ $data->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-info">GENERATE</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="sales_invoice_control_generate_page"></div>
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

        $("#sales_invoice_control_generate").on('submit', (function(e) {
            e.preventDefault();
            //$('#loader').show();
            $.ajax({
                url: "sales_invoice_control_generate",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    if (data == 'no_data') {
                        Swal.fire(
                            'Cannot Proceed',
                            'No Data Found!',
                            'error'
                        )
                    } else {
                        $('#sales_invoice_control_generate_page').html(data);
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
