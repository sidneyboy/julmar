@extends('layouts.master')

@section('title', 'LOGISTIC DR LIST')

@section('navbar')


@section('sidebar')


@section('content')

    <br />
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">LOGISTIC DR LIST</h3>

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
                    <table class="table table-bordered table-hover" id="example3">
                        <thead>
                            <tr>
                                <th>Delivery Receipt</th>
                                <th>Location</th>
                                <th>Store Name</th>
                                <th>Agent</th>
                                <th>Principal</th>
                                <th>Sku Type</th>
                                <th>Total Amount</th>
                                <th>DR Printed Date</th>
                                <th>Logistic Status</th>
                                {{-- <th>Status Option</th>
                                <th><input type="checkbox" class="form-control" name="select-all" id="select-all" /></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_invoice as $data)
                                <tr>
                                    <td>{{ $data->delivery_receipt }}</td>
                                    <td>{{ $data->customer->location->location }}</td>
                                    <td>{{ $data->customer->store_name }}</td>
                                    <td>{{ $data->agent->full_name }}</td>
                                    <td>{{ $data->principal->principal }}</td>
                                    <td>{{ $data->sku_type }}</td>
                                    <td>{{ number_format($data->total, 2, '.', ',') }}</td>
                                    <td>{{ $data->sales_invoice_printed }}</td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-info btn-sm btn-block" data-toggle="modal"
                                            data-target="#exampleModal{{ $data->id }}">
                                            @if ($data->logistic_status != null)
                                                {{ $data->logistic_status }}
                                            @else
                                                No Actions Yet
                                            @endif
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Logistic History</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered table-sm table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Posted</th>
                                                                    <th>Updated</th>
                                                                    <th>Status</th>
                                                                    <th>No. of Days</th>
                                                                    <th>User</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data->sales_invoice_status_logs as $details)
                                                                    <tr>
                                                                        <td>{{ $details->posted }}</td>
                                                                        <td>{{ $details->updated }}</td>
                                                                        <td>{{ $details->status }}</td>
                                                                        <td>{{ $details->no_of_days }}</td>
                                                                        <td>{{ $details->user->name }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <select name="status_option" required class="form-control select2" style="width:100%;" required>
                                            <option value="" default>Select</option>
                                            <option value="received_by_warehouse">Received By Warehouse Incharge</option>
                                            <option value="out_from_warehouse">out_from_warehouse</option>
                                            <option value=""></option>
                                        </select>
                                    </td>
                                    <td><input class="form-control" type="checkbox" name="sales_invoice_id[]"
                                            value="{{ $data->id }}" /></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

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

        $('#select-all').click(function(event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });

        $('#example3').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });

        // $("#received_id").change(function() {
        //     var received_id = $(this).val();
        //     $('.loading').show();
        //     $.post({
        //         type: "POST",
        //         url: "/transfer_to_branch_show_input",
        //         data: 'received_id=' + received_id,
        //         success: function(data) {

        //             //console.log(data);
        //             $('.loading').hide();
        //             $('#show_return_inputs').html(data);

        //         },
        //         error: function(error) {
        //             console.log(error);
        //         }
        //     });
        // });
    </script>
    </body>

    </html>
@endsection
