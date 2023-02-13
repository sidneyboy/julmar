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
                    <div class="col-md-8">
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
                    <div class="col-md-4">
                        <div class="container">
                            <nav class="navbar navbar-default">
                                <ul class="nav navbar-nav" style="width:100%;">
                                    <li> <button class="btn btn-info navbar-btn btn-flat" type="button" id="info"
                                            style="width:100%;" id="submit" type="submit" name="submit" value="Submit"
                                            onclick="return submitView()">Warned products</button></li>
                                    <li> <button class="btn btn-success navbar-btn btn-flat" type="button" id="info"
                                            style="width:100%;" id="submit" type="submit" name="submit" value="Submit"
                                            onclick="return submitInfo()">Update Info</button></li>
                                    <li> <button class="btn btn-warning navbar-btn btn-flat" type="button"
                                            onclick="return update_price()" style="width:100%;">Update Price</button></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Search Method</label>
                            <select name="search_method" id="search_method" style="width:100%;"
                                class="form-control select2bs4">
                                <option value="" default>SELECT METHOD</option>
                                <option value="sku_code">SKU CODE</option>
                                <option value="sku_description">SKU DESCRIPTION</option>
                                <option value="principal">PRINCIPAL</option>
                                <option value="category">CATEGORY</option>
                                <option value="uom">UOM</option>
                                <option value="sku_type">SKU TYPE</option>
                                <option value="remarks">REMARKS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Data</label>
                            <input type="text" id="data" class="form-control" placeholder="Data you want as output">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button style="width:100%;" id="generate_data"
                                class="btn btn-primary btn-flat btn-block">Generate Date</button>
                        </div>
                    </div>
                </div>
                <div class="table table-responsive">
                    <div id="show_data"></div>

                </div>
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

        $(document).ready(function() {
            $("#generate_data").click(function() {
                var search_method = $('#search_method').val();
                var data = $('#data').val();
                $('.loading').show();
                $.post({
                    type: "POST",
                    url: "search_sku_list",
                    data: 'search_method=' + search_method + '&data=' + data,
                    success: function(data) {

                        if (data == 'no_data_found') {
                            Swal.fire(
                                'NO DATA FOUND!',
                                'SEARCH AGAIN',
                                'error'
                            )
                            $('.loading').hide();
                        } else if (data == 'select_search_method') {
                            Swal.fire(
                                'SELECT SEARCH METHOD',
                                'SELECT NOW TO PROCEED !',
                                'error'
                            )
                            $('.loading').hide();
                        } else {
                            $('.loading').hide();
                            $('#show_data').html(data);
                        }

                    },
                    error: function(error) {

                    }
                });
            });


            function update_price() {
                var form = document.myform;
                var dataString = $(form).serialize();
                var show_data_update_form = $('#show_data_update_form');
                $.ajax({
                    type: 'POST',
                    url: '/sku_list_update_price',
                    data: dataString,
                    success: function(data) {
                        console.log(data);
                        show_data_update_form.html(data);
                    }
                });
                return false;
            }

            function update_price_save() {
                var form = document.myform;
                var dataString = $(form).serialize();
                $.ajax({
                    type: 'POST',
                    url: '/sku_list_update_price_save',
                    data: dataString,
                    success: function(data) {
                        console.log(data);
                    }
                });
                return false;
            }

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                // $('.loading').show();
                var page = $(this).attr('href').split('page=')[1];

                fetch_data(page);
            });

            function fetch_data(page) {
                var search_method = $('#search_method').val();
                var second_parameter = $('#second_parameter').val();
                var principal_name = $('#principal_name').val();
                $.ajax({
                    url: "/pagination/fetch_data?page=" + page + '&second_parameter=' + second_parameter +
                        '&search_method=' + search_method + '&principal_name=' + principal_name,
                    success: function(data) {
                        $('.loading').hide();
                        $('#show_data').html(data);
                    }
                });
            }
        });
    </script>
    </body>

    </html>
@endsection
