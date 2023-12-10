@extends('layouts.master')

@section('title', 'Chart of Accounts')

@section('navbar')


@section('sidebar')


@section('content')

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <form id="chart_of_accounts_transaction_proceed">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="font-weight: bold;">CHART OF ACCOUNTS</h3>

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

                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Transaction</label>
                            <select name="transaction" id="transaction" required class="form-control">
                                <option value="" default>Select</option>
                                <option value="new_general_ledger">New General Ledger</option>
                                <option value="insert_subsidiary_ledger">Insert Subsidiary Ledger</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div id="chart_of_accounts_transaction_page"></div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
                </div>
            </div>
            <!-- /.card -->
        </form>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">DETAILS</h3>
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
                <div id="chart_of_accounts_transaction_proceed_page"></div>
            </div>
            <!-- /.card-body -->
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">FINAL</h3>
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
                <div id="chart_of_accounts_final_summary_page"></div>
            </div>
            <!-- /.card-body -->
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


        $("#transaction").change(function() {
            //$('.loading').show();
            var transaction = $('#transaction').val();
            $.post({
                type: "POST",
                url: "/chart_of_accounts_transaction",
                data: 'transaction=' + transaction,
                success: function(data) {
                    $('.loading').hide();
                    $('#chart_of_accounts_transaction_page').html(data)
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
        });



        $("#chart_of_accounts_transaction_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "chart_of_accounts_transaction_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    $('#chart_of_accounts_transaction_proceed_page').html(data);
                    // if (data == 'no_input') {
                    //     $('#loader').hide();
                    //     Swal.fire(
                    //         'CANNOT PROCEED!',
                    //         'PRINCIPAL AND UOM FIELD ARE NEEDED',
                    //         'error'
                    //     )
                    // } else {
                    //     $('#loader').hide();
                    //     $('#show_input').html(data);
                    // }
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
