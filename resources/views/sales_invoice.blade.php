@extends('layouts.master')
@section('title', 'SALES INVOICE PRINT')
@section('navbar')
@section('sidebar')
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SALES INVOICE PRINT</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('sales_invoice_generate') }}" target="_blank" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label>Sales Invoice</label>
                            <select name="sales_invoice_id" style="width:100%;" class="form-control select2bs4" required>
                                <option value="" default>Select</option>
                                @foreach ($sales_invoice as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->agent->full_name . ' - ' . $data->principal->principal . ' - ' . $data->delivery_receipt . ' - ' . $data->total }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button class="btn btn-info btn-sm float-right" type="submit">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="sales_invoice_generate_page"></div>
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
    </script>
    </body>

    </html>
@endsection
