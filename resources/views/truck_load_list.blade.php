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
                @if (session('success'))
                    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="table table-responsive">
                    <table class="table table-bordered table-striped table-sm" style="width:100%;font-size:11px"
                        id="example1">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Sales Area</th>
                                <th>Trucking Company</th>
                                <th>Plate #</th>
                                <th>Driver</th>
                                <th>Contact No.</th>
                                <th>Helper 1</th>
                                <th>Helper 2</th>
                                <th>No. of Invoice</th>
                                <th>Total Outlet</th>
                                <th>Loading Date</th>
                                <th>Updated By</th>
                                <th>Departure Date</th>
                                <th>Updated By</th>
                                <th>Arrival Date</th>
                                <th>Updated By</th>
                                <th>Departure SG</th>
                                <th>Arrival SG</th>
                                <th>Fuel Given Amount</th>
                                <th>Remarks</th>
                                <th>Total Expense</th>
                                <th>Total Expense Updated By</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logistics as $data)
                                <tr>
                                    <td>{{ $data->user_id }}</td>
                                    <td>{{ $data->location->location }}</td>
                                    <td>{{ $data->trucking_company }}</td>
                                    <td>
                                        <a href="{{ url('truck_load_list_print',[
                                            'id' => $data->id,
                                        ]) }}" target="_blank" class="btn btn-info btn-block btn-sm">{{ $data->truck->plate_no }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('truck_load_list_driver_print',[
                                            'id' => $data->id,
                                        ]) }}" target="_blank" class="btn btn-info btn-block btn-sm">{{ $data->driver }}</a>
                                    </td>
                                    <td>{{ $data->contact_number }}</td>
                                    <td>{{ $data->helper_1 }}</td>
                                    <td>{{ $data->helper_2 }}</td>
                                    <td>{{ $data->number_of_invoices }}</td>
                                    <td>{{ $data->total_outlet }}</td>
                                    <td>

                                        @if ($data->loading_date == null)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-block btn-primary"
                                                data-toggle="modal"
                                                data-target="#exampleModalloading_date{{ $data->id }}">
                                                Update {{ $data->loading_date }}
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalloading_date{{ $data->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update Loading
                                                                Date</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('truck_load_lost_update_loading_date') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="date" class="form-control"
                                                                    name="loading_date" required>

                                                                <input type="text" value="{{ $data->id }}"
                                                                    name="id">
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
                                        @else
                                            {{ $data->loading_date }}
                                        @endif

                                    </td>
                                    <td>
                                        @if ($data->loading_date_updated_by != null)
                                            {{ $data->loading_date_updated_by_user->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->departure_date == null)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-block btn-primary"
                                                data-toggle="modal"
                                                data-target="#exampleModaldeparture_date{{ $data->id }}">
                                                Update {{ $data->departure_date }}
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModaldeparture_date{{ $data->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update Departure
                                                                Date</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('truck_load_lost_update_departure_date') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="date" class="form-control"
                                                                    name="departure_date" required>

                                                                <input type="text" value="{{ $data->id }}"
                                                                    name="id">
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
                                        @else
                                            {{ $data->loading_date }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->departure_date_updated_by != null)
                                            {{ $data->departure_date_updated_by_user->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->arrival_date == null)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-block btn-primary"
                                                data-toggle="modal"
                                                data-target="#exampleModalarrival_date{{ $data->id }}">
                                                Update {{ $data->arrival_date }}
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalarrival_date{{ $data->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update Arrival
                                                                Date</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('truck_load_lost_update_arrival_date') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="date" class="form-control"
                                                                    name="arrival_date" required>

                                                                <input type="text" value="{{ $data->id }}"
                                                                    name="id">
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
                                        @else
                                            {{ $data->loading_date }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->arrival_date_updated_by != null)
                                            {{ $data->arrival_date_updated_by_user->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->sg_departure_noted_by == null)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#exampleModalsg_departure_noted_by{{ $data->id }}">
                                                Update
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade"
                                                id="exampleModalsg_departure_noted_by{{ $data->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update
                                                                Departure
                                                                Noted By SG</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form
                                                            action="{{ route('truck_load_lost_update_sg_departure_noted_by') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="text" name="sg_departure_noted_by"
                                                                    class="form-control" required>
                                                                <input type="hidden" name="id"
                                                                    value="{{ $data->id }}">
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
                                        @else
                                            {{ $data->sg_departure_noted_by }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->sg_arrival_noted_by == null)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#exampleModalsg_arrival{{ $data->id }}">
                                                Update
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalsg_arrival{{ $data->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update
                                                                Arrival
                                                                Noted By SG</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form
                                                            action="{{ route('truck_load_lost_update_sg_arrival_noted_by') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="text" name="sg_arrival_noted_by"
                                                                    class="form-control" required>
                                                                <input type="hidden" name="id"
                                                                    value="{{ $data->id }}">
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
                                        @else
                                            {{ $data->sg_arrival_noted_by }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->fuel_given_amount == null)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#exampleModalfuel_given{{ $data->id }}">
                                                Update
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalfuel_given{{ $data->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update
                                                                Fuel Given Amount</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('truck_load_lost_update_fuel_given') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="text" name="fuel_given_amount"
                                                                    class="form-control" required
                                                                    onkeypress="return isNumberKey(event)">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $data->id }}">
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
                                        @else
                                            {{ $data->fuel_given_amount }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->remarks == null)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#exampleModalremarks{{ $data->id }}">
                                                Update
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalremarks{{ $data->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update
                                                                Remarks</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('truck_load_lost_update_remarks') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="text" name="remarks" class="form-control"
                                                                    required>
                                                                <input type="hidden" name="id"
                                                                    value="{{ $data->id }}">
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
                                        @else
                                            {{ $data->remarks }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->total_expense == null)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#exampleModaltotal_expense{{ $data->id }}">
                                                Update
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModaltotal_expense{{ $data->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update
                                                                Total Expense</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('truck_load_lost_update_total_expense') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="text" name="total_expense"
                                                                    class="form-control" required
                                                                    onkeypress="return isNumberKey(event)">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $data->id }}">
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
                                        @else
                                            {{ $data->total_expense }}
                                        @endif
                                    </td>
                                    <td>{{ $data->total_expense_updated_by }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-block btn-success" id="complete">Complete</button>
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

        $(document).ready(function() {
            var table = $('#example1').DataTable({
                responsive: false,
                paging: false,
                ordering: true,
                info: false,
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
            new $.fn.dataTable.FixedHeader(table);
        });
    </script>
    </body>

    </html>
@endsection
