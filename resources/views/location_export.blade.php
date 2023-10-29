@extends('layouts.master')

@section('navbar')


@section('sidebar')


@section('content')

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">LOCATION EXPORT</h3>

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
                    <div class="col-md-12">
                        <label for="">Sales Area List</label>
                        <table class="table table-bordered table-hover table-striped table-sm" id="example1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Sales Area</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($location as $data)
                                    @foreach ($data->location_details as $details)
                                        <tr>
                                            <td>{{ $details->id }}</td>
                                            <td>{{ $data->location . ' - ' . $details->barangay }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
        $(document).ready(function() {
            var table = $('#example1').DataTable({
                responsive: true,
                paging: false,
                ordering: true,
                info: false,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'csvHtml5',
                    filename: 'Sales Area',
                    title: 'Sales Area',
                }, ]
            });
            new $.fn.dataTable.FixedHeader(table);
        });
    </script>
    </body>

    </html>
@endsection
