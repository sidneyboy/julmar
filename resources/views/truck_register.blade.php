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
                <h3 class="card-title" style="font-weight: bold;">TRUCK REGISTRATION</h3>

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
                <form action="{{ route('truck_register_save') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Plate No:</label>
                                <input type="text" class="form-control" required name="plate_no">
                            </div>
                            <div class="col-md-4">
                                <label>Capacity(Kg):</label>
                                <input type="text" class="form-control" required name="capacity">
                            </div>
                            <div class="col-md-4">
                                <label>Truck Model:</label>
                                <input type="text" class="form-control" required name="model">
                            </div>
                            <div class="col-md-12">
                                <br />
                                <button type="submit" class="btn btn-success btn-block">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover table-sm table-striped" id="example1" style="width:100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Model</th>
                                <th>Plate No</th>
                                <th>Capacity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($truck as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->model }}</td>
                                    <td>{{ $data->plate_no }}</td>
                                    <td>{{ $data->capacity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
