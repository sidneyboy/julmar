@extends('layouts.master')
@section('navbar')
@section('sidebar')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">New Principal</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <form action="{{ route('new_principal_process') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if (session('success'))
                                            <div class="alert alert-success border-left-success alert-dismissible fade show"
                                                role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        @if (session('error'))
                                            <div class="alert alert-danger border-left-danger alert-dismissible fade show"
                                                role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Principal:</label>
                                        <input type="text" class="form-control" name="principal" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Contact Number:</label>
                                        <input type="text" class="form-control" name="contact_number" required>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button class="btn btn-sm float-right btn-success">Submit New Principal</button>
                            </div>
                        </form>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">ID #</th>
                                        <th style="text-align: center;">PRINCIPAL</th>
                                        <th style="text-align: center;">CONTACT #</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($principal_data as $principal)
                                        <tr>
                                            <td style="text-align: center">{{ $principal->id }}</td>
                                            <td style="text-align: center">{{ $principal->principal }}</td>
                                            <td style="text-align: center">{{ $principal->contact_number }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
    </div>


@endsection
@section('footer')
    @parent

    </body>

    </html>
@endsection
