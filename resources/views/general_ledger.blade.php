@extends('layouts.master')

@section('title', 'General Ledger')

@section('navbar')


@section('sidebar')


@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">LEDGER</h3>

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
                <form id="general_ledger_generate">
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom: 10px;">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right" name="date_range" id="reservation">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="report_type" class="form-control" id="report_type" required>
                                    <option value="" default>SELECT REPORT TYPE</option>
                                    <option value="general_ledger">GENERAL LEDGER</option>
                                    <option value="subsidiary_ledger">SUBSIDIARY LEDGER</option>
                                    <option value="trial_balance">TRIAL BALANCE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div id="general_ledger_show_report_type_page"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-info float-right btn-sm" type="submit">Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="show_report_list"></div>
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

        $('#report_type').on('change', function(e) {
            var report_type = $('#report_type').val();
            $('#loader').show();
            $.post({
                type: "POST",
                url: "/general_ledger_show_report_type",
                data: 'report_type=' + report_type,
                success: function(data) {

                    $('#loader').hide();
                    $('#general_ledger_show_report_type_page').html(data);

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

        // $('#generate').on('click', function(e) {
        //     var date = $('#reservation').val();
        //     var principal = $('#principal').val();
        //     $('#loader').show();
        //     $.post({
        //         type: "POST",
        //         url: "/general_ledger_generate",
        //         data: 'date=' + date + '&principal=' + principal,
        //         success: function(data) {

        //             $('#loader').hide();
        //             $('#show_report_list').html(data);

        //         },
        //         error: function(error) {
        //             $('#loader').hide();
        //             Swal.fire(
        //                 'Cannot Proceed',
        //                 'Please Contact IT Support',
        //                 'error'
        //             )

        //         }
        //     });
        // });

        $("#general_ledger_generate").on('submit', (function(e) {
            e.preventDefault();
            //$('#loader').show();
            $.ajax({
                url: "general_ledger_generate",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    $('#show_report_list').html(data);
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
