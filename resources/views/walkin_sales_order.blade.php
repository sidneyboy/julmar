@extends('layouts.master')
@section('title', 'Walk In SO')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">WALK-IN SALES ORDER</h3>
    </div>
    <div class="card-body">
      <form id="walkin_sales_order_generate_form" enctype="multipart/form-data" method="post">
        @csrf
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Store Name:</label>
                <select class="form-control select2" required name="customer" id="customer" style="width:100%;">
                  <option value="" default>Select Customer</option>
                  @foreach($customer as $data)
                  <option value="{{ $data->id .",". $data->store_name }}">{{ $data->store_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Type:</label>
                <select class="form-control select2" required name="type" id="type" style="width:100%;">
                  <option value="" default>Select Type</option>
                  <option value="Case">Case</option>
                  <option value="Butal">Butal</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Principal:</label>
                <select class="form-control select2" required name="principal_id" id="principal_id" style="width:100%;">
                  <option value="" default>Select Principal</option>
                  @foreach($principal as $data)
                  <option value="{{ $data->id .",". $data->principal  }}">{{ $data->principal }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-12">
               <div id="walk_sales_order_generate_sku_page"></div>
            </div> 
            <div class="col-md-12">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-info btn-block">PROCEED TO QTY FORM</button>
            </div>
          </div>

      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

   <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">Generated Summary</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div id="walkin_sales_order_generate_page"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
       
    </div>
    <!-- /.card-footer-->
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">Final Summary</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div id="walkin_sales_order_generate_final_summary_page"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
       
    </div>
    <!-- /.card-footer-->
  </div>
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
    principal_id = $('#principal_id').val();
    type = $('#type').val();
    price_level = $('#price_level').val();
    customer = $('#customer').val();
     $('.loading').show();
      $.post({
          type: "POST",
          url: "/walk_sales_order_generate_sku",
          data: 'principal_id=' + principal_id + '&type=' + type + '&price_level=' + price_level + '&customer=' + customer,
          success: function(data){
            
            if (data == 'all_data_input_needed') {
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Customer,Type and Price Level inputs are needed!',
                showConfirmButton: false,
                timer: 1500
              })
              $('.loading').hide();
            }else{
              $('#walk_sales_order_generate_sku_page').html(data);
              $('.loading').hide();
            }
          }
      });
    });

  $("#walkin_sales_order_generate_form").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
      
        $.ajax({
          url: "walkin_sales_order_generate_form",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             $('#walkin_sales_order_generate_page').html(data);
          },
        });
    }));







</script>
</body>
</html>
@endsection