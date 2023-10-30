@extends('layouts.master')

@section('title', 'TRUCK')

@section('navbar')


@section('sidebar')


@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">LOGISTICS LIST</h3>

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
                @if (session('error'))
                    <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="table table-responsive">
                    <table class="table table-bordered table-striped table-sm" style="width:100%;font-size:13px"
                        id="example1">
                        <thead>
                            <tr>
                                <th style="text-align: center;">User</th>
                                <th style="text-align: center;">Sales Area</th>
                                <th style="text-align: center;">Trucking Company</th>
                                <th style="text-align: center;">Plate #</th>
                                <th style="text-align: center;">Driver</th>
                                <th style="text-align: center;">Contact No.</th>
                                <th style="text-align: center;">Helper 1</th>
                                <th style="text-align: center;">Helper 2</th>
                                <th style="text-align: center;">No. of Invoice</th>
                                <th style="text-align: center;">Total Outlet</th>
                                <th style="text-align: center;">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logistics as $data)
                                <tr>
                                    <td>{{ $data->user->name }}</td>
                                    <td>{{ $data->location->location }}</td>
                                    <td>{{ $data->trucking_company }}</td>
                                    <td>
                                        <a href="{{ url('truck_load_list_print', [
                                            'id' => $data->id,
                                        ]) }}"
                                            target="_blank"
                                            class="btn btn-info btn-block btn-sm">{{ $data->truck->plate_no }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('truck_load_list_driver_print', [
                                            'id' => $data->id,
                                        ]) }}"
                                            target="_blank" class="btn btn-info btn-block btn-sm">{{ $data->driver }}</a>
                                    </td>
                                    <td>{{ $data->contact_number }}</td>
                                    <td>{{ $data->helper_1 }}</td>
                                    <td>{{ $data->helper_2 }}</td>
                                    <td style="text-align: center;">
                                        <button class="btn btn-sm btn-block btn-primary" id="show_logistics_details"
                                            value="{{ $data->id }}"
                                            type="submit">{{ $data->number_of_invoices }}</button>
                                    </td>
                                    <td style="text-align: center;">{{ $data->total_outlet }}</td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal"
                                            data-target="#exampleModal{{ $data->id }}">
                                            View
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('truck_load_list_update_data') }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type="hidden" name="logistics_id"
                                                                    value="{{ $data->id }}">
                                                                <select id="logistics_details_data"
                                                                    name="logistics_details_data"
                                                                    class="form-control form-control-sm" required>
                                                                    <option value="" default>Select</option>
                                                                    @if ($data->loading_date == null)
                                                                        <option value="loading_date">Loading date</option>
                                                                    @endif
                                                                    @if ($data->departure_date == null)
                                                                        <option value="departure_date">Departure date
                                                                        </option>
                                                                    @endif
                                                                    @if ($data->sg_departure_noted_by == null)
                                                                        <option value="sg_departure_noted_by">Departure
                                                                            signed
                                                                            by
                                                                            S.Guard</option>
                                                                    @endif
                                                                    @if ($data->arrival_date == null)
                                                                        <option value="arrival_date">Arrival date</option>
                                                                    @endif
                                                                    @if ($data->sg_arrival_noted_by == null)
                                                                        <option value="sg_arrival_noted_by">Arrival signed
                                                                            by
                                                                            S.Guard</option>
                                                                    @endif
                                                                    @if ($data->fuel_given_amount == null)
                                                                        <option value="fuel_given_amount">Fuel given amount
                                                                        </option>
                                                                    @endif
                                                                    @if ($data->total_expense == null)
                                                                        <option value="total_expense">Total expense</option>
                                                                    @endif
                                                                    @if ($data->remarks == null)
                                                                        <option value="remarks">Remarks</option>
                                                                    @endif
                                                                </select>

                                                                <br />
                                                                <input type="text" id="string_value"
                                                                    name="string_value"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="Text value" style="display:none;">

                                                                <input type="text" id="integer_value"
                                                                    name="integer_value"
                                                                    onkeypress="return isNumberKey(event)"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="Amount value" style="display:none;">

                                                                <input type="date" id="date_value" name="date_value"
                                                                    class="form-control form-control-sm"
                                                                    style="display:none;">
                                                            </div>
                                                            <table
                                                                class="table table-bordered table-hover table-striped table-sm"
                                                                style="font-size:12px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Loading Date:</th>
                                                                        <th style="text-align:center;">
                                                                            @if ($data->loading_date == null)
                                                                                N/A
                                                                            @else
                                                                                {{ $data->loading_date }}
                                                                            @endif
                                                                        </th>
                                                                        <th>Updated By:</th>
                                                                        <th style="text-align:center;">
                                                                            @if ($data->loading_date_updated_by == null)
                                                                                N/A
                                                                            @else
                                                                                {{ $data->loading_date_updated_by_user->name }}
                                                                            @endif
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Departure Date:</th>
                                                                        <th style="text-align:center;">
                                                                            @if ($data->departure_date == null)
                                                                                N/A
                                                                            @else
                                                                                {{ $data->departure_date }}
                                                                            @endif
                                                                        </th>
                                                                        <th>Updated By:</th>
                                                                        <th style="text-align:center;">
                                                                            @if ($data->departure_date_updated_by == null)
                                                                                N/A
                                                                            @else
                                                                                {{ $data->departure_date_updated_by_user->name }}
                                                                            @endif
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>S.Guard:</th>
                                                                        <th style="text-align:center;" colspan="3">
                                                                            @if ($data->sg_departure_noted_by == null)
                                                                                N/A
                                                                            @else
                                                                                {{ $data->sg_departure_noted_by }}
                                                                            @endif
                                                                        </th>

                                                                    </tr>
                                                                    <tr>
                                                                        <th>Arrival Date:</th>
                                                                        <th style="text-align:center;">
                                                                            @if ($data->arrival_date == null)
                                                                                N/A
                                                                            @else
                                                                                {{ $data->arrival_date }}
                                                                            @endif
                                                                        </th>
                                                                        <th>Updated By:</th>
                                                                        <th style="text-align:center;">
                                                                            @if ($data->arrival_date_updated_by == null)
                                                                                N/A
                                                                            @else
                                                                                {{ $data->arrival_date_updated_by_user->name }}
                                                                            @endif
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>S.Guard:</th>
                                                                        <th style="text-align:center;" colspan="3">
                                                                            @if ($data->sg_arrival_noted_by == null)
                                                                                N/A
                                                                            @else
                                                                                {{ $data->sg_arrival_noted_by }}
                                                                            @endif
                                                                        </th>

                                                                    </tr>
                                                                    <tr>
                                                                        <th>Fuel Given Amount:</th>
                                                                        <th style="text-align:center;">
                                                                            @if ($data->fuel_given_amount == null)
                                                                                N/A
                                                                            @else
                                                                                {{ $data->fuel_given_amount }}
                                                                            @endif
                                                                        </th>
                                                                        <th>Updated By:</th>
                                                                        <th style="text-align:center;">
                                                                            @if ($data->fuel_given_updated_by == null)
                                                                                N/A
                                                                            @else
                                                                                {{ $data->fuel_given_updated_by_user->name }}
                                                                            @endif
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Total_expense:</th>
                                                                        <th style="text-align:center;">
                                                                            @if ($data->total_expense == null)
                                                                                N/A
                                                                            @else
                                                                                {{ number_format($data->total_expense, 2, '.', ',') }}
                                                                            @endif
                                                                        </th>
                                                                        <th>Updated By:</th>
                                                                        <th style="text-align:center;">
                                                                            @if ($data->total_expense_updated_by == null)
                                                                                N/A
                                                                            @else
                                                                                {{ $data->total_expense_updated_by_user->name }}
                                                                            @endif
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Remarks:</th>
                                                                        <th colspan="3">{{ $data->remarks }}</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-sm btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="truck_load_proceed_page"></div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
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
                <div id="truck_logistics_details_show_page"></div>
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

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        $("#logistics_details_data").change(function() {
            if ($(this).val() == 'loading_date') {
                $('#integer_value').hide();
                $('#string_value').hide();
                $('#date_value').show();
            } else if ($(this).val() == 'departure_date') {
                $('#integer_value').hide();
                $('#string_value').hide();
                $('#date_value').show();
            } else if ($(this).val() == 'arrival_date') {
                $('#integer_value').hide();
                $('#string_value').hide();
                $('#date_value').show();
            } else if ($(this).val() == 'sg_departure_noted_by') {
                $('#integer_value').hide();
                $('#string_value').show();
                $('#date_value').hide();
            } else if ($(this).val() == 'sg_arrival_noted_by') {
                $('#integer_value').hide();
                $('#string_value').show();
                $('#date_value').hide();
            } else if ($(this).val() == 'remarks') {
                $('#integer_value').hide();
                $('#string_value').show();
                $('#date_value').hide();
            } else if ($(this).val() == 'fuel_given_amount') {
                $('#integer_value').show();
                $('#string_value').hide();
                $('#date_value').hide();
            } else if ($(this).val() == 'total_expense') {
                $('#integer_value').show();
                $('#string_value').hide();
                $('#date_value').hide();
            }
        });

        $("#show_logistics_details").click(function() {
            // $('#loader').show();
            var logistic_id = $(this).val();
            $.post({
                type: "POST",
                url: "/truck_logistics_details_show",
                data: 'logistic_id=' + logistic_id,
                success: function(data) {
                    $('#loader').hide();
                    $('#truck_logistics_details_show_page').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $(document).ready(function() {
            var table = $('#example1').DataTable({
                responsive: false,
                paging: false,
                ordering: true,
                info: false,
                // dom: 'Bfrtip',
                // buttons: [
                //     'copyHtml5',
                //     'excelHtml5',
                //     'csvHtml5',
                //     'pdfHtml5'
                // ]
            });
            new $.fn.dataTable.FixedHeader(table);
        });
    </script>
    </body>

    </html>
@endsection
