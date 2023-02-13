@extends('layouts.master')
@section('title', 'Agent')
@section('navbar')
@section('sidebar')
@section('content')
    <br />
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">ADD NEW AGENT</h3>
            </div>
            <div class="card-body">
                <form id="agent_saved">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Full Name:</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Principal:</label>
                            <select class="form-control select2" style="width:100%;" multiple="multiple" name="principal[]">
                                @foreach ($principal as $data)
                                    <option value="{{ $data->id }}">{{ $data->principal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Location:</label>
                            <select class="form-control select2" style="width:100%;" name="location">
                                <option value="" default>Select</option>
                                @foreach ($location as $data)
                                    <option value="{{ $data->id }}">{{ $data->location }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Contact #:</label>
                            <input type="text" name="contact_number" required class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Address:</label>
                            <input type="text" name="full_address" required class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Email Address:</label>
                            <input type="email" name="email_address" required class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-success btn-block">SUBMIT NEW AGENT</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="row">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>FULL NAME</th>
                                    <th>CONTACT #</th>
                                    <th>ADDRESS</th>

                                    <th>ASSIGNED LOCATION</th>
                                    <th>EMAIL ADDRESS</th>
                                    <th>PRINCIPALS</th>
                                    <th>ADDED BY:</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agent as $data)
                                    <tr>
                                        <td>{{ $data->full_name }}</td>
                                        <td>{{ $data->contact_number }}</td>
                                        <td>{{ $data->full_address }}</td>
                                        <td>{{ $data->location->location }}</td>
                                        <td>{{ $data->email_address }}</td>
                                        <td>
                                            @foreach ($data->agent_principal as $agent_principal)
                                                {{ $agent_principal->principal->principal . ',' }}
                                            @endforeach
                                        </td>
                                        <td style="text-transform: uppercase;">{{ $data->user->name }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
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

        $("#agent_saved").on('submit', (function(e) {
            e.preventDefault();
            $('.loading').show();
            $.ajax({
                url: "agent_saved",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    // if(data == 'saved'){
                    //   Swal.fire({
                    //     position: 'top-end',
                    //     icon: 'success',
                    //     title: 'New Agent saved!',
                    //     showConfirmButton: false,
                    //     timer: 1500
                    //   })
                    //   location.reload();
                    //   $('.loading').hide();
                    // }else{
                    //   Swal.fire(
                    //   'Something went wrong!',
                    //   'Redo process or contact system administrator',
                    //   'error'
                    //   )
                    //   $('.loading').hide();
                    // }
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'New Agent saved!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    location.reload();
                    $('.loading').hide();
                },
            });
        }));
    </script>
    </body>

    </html>
@endsection
