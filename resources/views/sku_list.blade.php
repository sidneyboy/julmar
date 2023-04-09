@extends('layouts.master')
@section('navbar')
@section('sidebar')
@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SKU LIST</h3>
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
                        <div class="position-relative p-3 bg-gray" style="height: 130px">
                            <div class="ribbon-wrapper">
                                <div class="ribbon bg-primary">
                                    LEGEND
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul>
                                        <li>CODE - ITEM CODE</li>
                                        <li>UOM - UNIT OF MEASUREMENT</li>
                                        <li>TYPE - ITEM TYPE(CASE / BUTAL)</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul>
                                        <li>QOH - QUANTITY ON HAND</li>
                                        <li>ESE - EQUIVALENT SKU ENTRY NO.</li>
                                        <li>EBQ - EQUIVALENT BUTAL SKU</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <form id="sku_list_show_data">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="">Search:</label>
                            <input type="text" class="form-control" placeholder="Code, Description, Type" name="search"
                                required>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button style="width:100%;" id="generate_data"
                                    class="btn btn-primary btn-block">Search</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="sku_list_show_data_page"></div>
                        </div>
                    </div>

                </form>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->

    </section>
@endsection
@section('footer')
    @parent
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $("#sku_list_show_data").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "sku_list_show_data",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#sku_list_show_data_page').html(data);
                    $('#loader').hide();
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
