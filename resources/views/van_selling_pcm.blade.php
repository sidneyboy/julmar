@extends('layouts.master')
@section('title', 'PCM VS')
@section('navbar')
@section('sidebar')
@section('content')
   
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING PCM</h3>
            </div>
            <div class="card-body">
                <form id="van_selling_pcm_generate_pcm_data" method="post">
                    @csrf
                    <div class="row">
                         <div class="col-md-4">
                            <div class="form-group">
                                <label>Select PCM Type</label>
                                <select name="pcm_type" id="pcm_type" class="form-control" required
                                    style="width:100%;">
                                    <option value="" default>SELECT</option>
                                    <option value="panel">PANEL</option>
                                    <option value="customer">CUSTOMER</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Select Salesman</label>
                                <select name="salesman" id="customer_id" class="form-control select2bs4" required
                                    style="width:100%;">
                                    <option value="" default>SELECT</option>
                                    @foreach ($customer as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->store_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Select Principal</label>
                                <select name="principal_id" id="principal_id" class="form-control" required
                                    style="width:100%;">
                                    <option value="" default>SELECT</option>
                                    @foreach ($principal as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->principal }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="van_selling_pcm_generate_sku_page"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm float-right btn-info">Proceed</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="van_selling_pcm_generate_pcm_data_page"></div>
            </div>
            <!-- /.card-footer-->
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">VAN SELLING PCM FINAL SUMMARY</h3>
            </div>
            <div class="card-body">
                <div id="van_selling_pcm_generate_final_summary_page"></div>
            </div>
            <!-- /.card-body -->
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

        $("#principal_id").change(function() {
            var principal_id = $(this).val();
            var customer_id = $('#customer_id').val();
            var pcm_type = $('#pcm_type').val();
            $('.loading').show();
            $.post({
                type: "POST",
                url: "/van_selling_pcm_generate_sku_per_principal",
                data: 'principal_id=' + principal_id + '&customer_id=' + customer_id + '&pcm_type=' + pcm_type,
                success: function(data) {

                    //console.log(data);
                    $('.loading').hide();
                    $('#van_selling_pcm_generate_sku_page').html(data);

                },
                error: function(error) {
                    console.log(error);
                }
            });
        });


        $("#van_selling_pcm_generate_pcm_data").on('submit', (function(e) {
            e.preventDefault();
            $('.loading').show();
            $.ajax({
                url: "van_selling_pcm_generate_pcm_data",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.loading').hide();
                    $('#van_selling_pcm_generate_pcm_data_page').html(data);
                },
            });
        }));
    </script>
    </body>

    </html>
@endsection
