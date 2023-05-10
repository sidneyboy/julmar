@extends('layouts.master')
@section('title', 'Customer Profile')
@section('navbar')
@section('sidebar')
@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">CUSTOMER PROFILE</h3>
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
                <table class="table table-bordered table-hover table-striped table-sm" style="font-size:13px;"
                    id="example1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Store Name</th>
                            <th>KOB</th>
                            <th>Credit Term</th>
                            <th>Credit Line</th>
                            <th>Location</th>
                            <th>Location ID</th>
                            <th>Contact Person</th>
                            <th>Contact Number</th>
                            <th>ADDITIONAL<br />INFORMATION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer as $data)
                            <tr>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->store_name }}</td>
                                <td>{{ $data->kind_of_business }}</td>
                                <td style="text-align: right">{{ $data->credit_term }}</td>
                                <td style="text-align: right">{{ number_format($data->credit_line_amount, 2, '.', ',') }}</td>
                                <td>{{ $data->location->location }}</td>
                                <td>{{ $data->location_id }}</td>
                                <td>
                                    @if ($data->contact_person)
                                        {{ $data->contact_person }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td style="text-align: right">
                                    @if ($data->contact_number)
                                        0{{ $data->contact_number }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        $(document).ready(function() {
            var table = $('#example1').DataTable({
                responsive: true,
                paging: true,
                ordering: true,
                info: true,
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    {
                        extend: 'csvHtml5',
                        filename: 'Booking Customer',
                    },
                    'pdfHtml5'
                ]
            });
            new $.fn.dataTable.FixedHeader(table);
        });
    </script>
    </body>

    </html>
@endsection
