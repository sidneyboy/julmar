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
                            <h3 class="card-title" style="font-weight: bold;">COLLECTION</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <form id="credit_memo_proceed">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">CM #</label>
                                        <select name="cm_id" style="width:100%;" class="form-control select2bs4" required>
                                            <option value="" default>Select</option>
                                            @foreach ($return_good_stock as $return_good_stock_data)
                                                <option value="{{ 'RGS-' . $return_good_stock_data->id }}">
                                                    @php
                                                        echo Str::upper(str_replace('PCM-',' ',$return_good_stock_data->pcm_number))
                                                    @endphp
                                                </option>
                                            @endforeach
                                            @foreach ($bad_order as $bad_order_data)
                                                <option value="{{ 'BO-' . $bad_order_data->id }}">
                                                    @php
                                                        echo Str::upper(str_replace('PCM-',' ',$bad_order_data->pcm_number))
                                                    @endphp
                                                </option>
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
                            <div id="credit_memo_proceed_page"></div>
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            {{-- <div class="row">
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
                            <div id="collection_final_summary_page"></div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div> --}}
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

        $("#credit_memo_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "credit_memo_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    $('#credit_memo_proceed_page').html(data);
                },
                error: function(error) {
                    $('#loader').hide();
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
