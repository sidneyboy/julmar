@extends('layouts.master')

@section('title', 'AP-Subsidiary')

@section('navbar')


@section('sidebar')


@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">AP SUBSIDIARY LEDGER CUT OFF</h3>

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
                <div class="table table-responsive">
                    <table class="table table-bordered table-striped table-sm" style="width:100%;font-size:15px;"
                        id="example1">
                        <thead>
                            <tr>
                                <th>Principal</th>
                                <th>Transaction Date</th>
                                <th>Description</th>
                                <th>DR</th>
                                <th>CR</th>
                                <th>Running</th>
                                <th>Remarks</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ap_ledger as $data)
                                <tr>
                                    <td>{{ $data->principal->principal }}</td>
                                    <td>{{ $data->transaction_date }}</td>
                                    <td>{{ $data->description }}</td>
                                    <td style="text-align: right">{{ number_format($data->debit_record, 2, '.', ',') }}
                                        @php
                                            $total_dr[] = $data->debit_record;
                                        @endphp
                                    </td>
                                    <td style="text-align: right">{{ number_format($data->credit_record, 2, '.', ',') }}
                                        @php
                                            $total_cr[] = $data->credit_record;
                                        @endphp
                                    </td>
                                    <td style="text-align: right">{{ number_format($data->running_balance, 2, '.', ',') }}
                                    </td>
                                    <td>{{ $data->remarks }}</td>
                                    <td>{{ $data->user->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right">{{ number_format(array_sum($total_dr), 2, '.', ',') }}</td>
                                <td style="text-align: right">{{ number_format(array_sum($total_cr), 2, '.', ',') }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <form id="ap_ledger_subsidiary_cut_off_save">
                    @csrf
                    <input type="hidden" name="principal_id" value="{{ $principal_id }}">
                    <button class="btn btn-sm float-right btn-success">Submit Cut-off</button>
                </form>
            </div>
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

        $("#ap_ledger_subsidiary_cut_off_save").on('submit', (function(e) {
            e.preventDefault();
            // $('#loader').show();
            $.ajax({
                url: "ap_ledger_subsidiary_cut_off_save",
                type: "get",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    // $('#loader').hide();
                    // Swal.fire({
                    //     position: 'top-end',
                    //     icon: 'success',
                    //     title: 'Your work has been saved',
                    //     showConfirmButton: false,
                    //     timer: 1500
                    // });

                    // location.reload();
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
