@extends('layouts.master')
@section('navbar')
@section('sidebar')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="font-weight: bold;">EWT RATE</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <form action="{{ route('ewt_rate_process') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label for="">EWT Rate:</label>
                                                <input type="text" class="form-control" name="ewt_rate" id="ewt_rate"
                                                    required>
                                            </div>
                                            <div class="col-md-4">
                                                <label>&nbsp;</label>
                                                <button class="btn btn-block float-right btn-info"
                                                    type="submit">Proceed</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-sm table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Added By</th>
                                                    <th style="text-align: center;">Ewt Rate</th>
                                                    <th style="text-align: center;">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ewt as $data)
                                                    <tr>
                                                        <td style="text-align: center;">{{ $data->user->name }}</td>
                                                        <td style="text-align: center;">{{ $data->ewt_rate / 100 }}</td>
                                                        <td style="text-align: center;">{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
    </div>


@endsection
@section('footer')
    @parent
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    </body>

    </html>
@endsection
