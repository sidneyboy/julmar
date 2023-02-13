@extends('layouts.master')

@section('title', 'TRUCK REGISTER')

@section('navbar')


@section('sidebar')


@section('content')

    <br />
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">TRUCK REGISTER</h3>

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
                    <table class="table table-bordered table-hover">
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
