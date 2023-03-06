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
                            <h3 class="card-title" style="font-weight: bold;">DISBURSEMENT</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <form id="disbursement_proceed">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Disbursement:</label>
                                        <select name="disbursement" class="form-control" required>
                                            <option value="" default>Select</option>
                                            <option value="payment to principal">Payment to Principal</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Principal:</label>
                                        <select name="principal_id" class="form-control" required>
                                            <option value="" default>Select</option>
                                            @foreach ($principal as $data)
                                                <option value="{{ $data->id }}">{{ $data->principal }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <br />
                                        <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div id="disbursement_proceed_page"></div>
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="font-weight: bold;">FINAL SUMMARY</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="disbursement_final_summary_page"></div>
                        </div>
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
        
        $("#disbursement_proceed").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            $('#hide_if_trigger').hide();
            $.ajax({
                url: "disbursement_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#disbursement_proceed_page').html(data);
                },
                error: function(error) {
                    Swal.fire(
                        'Cannot Proceed',
                        'Please Contact IT Support',
                        'error'
                    )
                }
            });
        }));
    </script>
    </body>

    </html>
@endsection