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
                            <h3 class="card-title" style="font-weight: bold;">DRIVER COLLECTION</h3>

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
                            <form id="driver_collection_proceed" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Search Per:</label>
                                        <select name="search_per" id="search_per" class="form-control" required>
                                            <option value="" default>SELECT</option>
                                            <option value="driver">DRIVER</option>
                                            <option value="invoice">INVOICE</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="driver_collection_search_per_generate_page"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <br />
                                        <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div id="driver_collection_proceed_page"></div>
                        </div>
                    </div>
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
                            <div id="driver_collection_final_summary_page"></div>
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

        $("#search_per").change(function() {
            //$('.loading').show();
            var search_per = $(this).val();
            $.post({
                type: "POST",
                url: "/driver_collection_search_per_generate",
                data: 'search_per=' + search_per,
                success: function(data) {
                    console.log(data);

                    $('#driver_collection_search_per_generate_page').html(data);
                    $('.loading').hide();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });


        $("#driver_collection_proceed").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "driver_collection_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    $('#driver_collection_proceed_page').html(data);
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
