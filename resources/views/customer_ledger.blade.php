@extends('layouts.master')

@section('title', 'Julmar')

@section('navbar')


@section('sidebar')


@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">CUSTOMER LEDGER</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <form id="customer_ledger_generate">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date Range</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="date_range" required class="form-control float-right"
                                        id="reservation">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Principal</label>
                                <select name="principal_id" class="form-control" required>
                                    <option value="" default>Select Principal</option>
                                    @foreach ($principal as $principal_data)
                                        <option value="{{ $principal_data->id }}">{{ $principal_data->principal }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Customer</label>
                                <select name="customer_id" class="form-control select2bs4" style="width:100%;" required>
                                    <option value="" default>Select Customer</option>
                                    @foreach ($customer as $customer_id)
                                        <option value="{{ $customer_id->id }}">{{ $customer_id->store_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Report</label>
                                <select name="report" class="form-control select2bs4" style="width:100%;" required>
                                    <option value="" default>Select</option>
                                    <option value="Sales Register">Sales Register</option>
                                    <option value="Accounts Receivable">Accounts Receivable</option>
                                    <option value="Principal Sales">Principal Sales</option>
                                    <option value="Cost of Sales">Cost of Sales</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm float-right btn-info">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="customer_ledger_generate_page"></div>
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


        $("#customer_ledger_generate").on('submit', (function(e) {
            e.preventDefault();
            //$('#loader').show();
            $.ajax({
                url: "customer_ledger_generate",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    $('#customer_ledger_generate_page').html(data);
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
