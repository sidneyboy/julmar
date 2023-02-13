@extends('layouts.master')
@section('title', 'VS EXPORT U/P')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">VAN SELLING EXPORT UPDATED PRICE LIST</h3>
    </div>
    <div class="card-body">
      <form id="van_selling_export_updated_price_generate_data">
        <div class="row">
          <div class="col-md-6">
          	<label>LOCATION:</label>
            <select class="form-control select2" name="location_id" id="location_id" style="width:100%;" required>
             	<option value="" default>SELECT</option>
             	@foreach($location as $data)
             		<option value="{{ $data->id }}">{{ $data->location }}</option>
             	@endforeach
             </select>
          </div>
          <div class="col-md-6">
            <label>PRINCIPAL:</label>
            <select class="form-control select2" name="principal_id" id="principal_id" style="width:100%;" required>
              <option value="" default>SELECT</option>
              @foreach($principal as $data)
                <option value="{{ $data->principal }}">{{ $data->principal }}</option>
              @endforeach
             </select>
          </div>
          <div class="col-md-12">
          	<div id="van_selling_export_updated_price_generate_customer_page"></div>
          </div>
          <div class="col-md-12">
              <label>&nbsp;</label>
              <button class="btn btn-info btn-block" type="submit" >GENERATE SKU</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="van_selling_export_updated_price_generate_data_page"></div>
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

   $("#location_id" ).change(function() {
     var location_id = $(this).val(); 
     $('.loading').show();       
      $.post({
      type: "POST",
      url: "/van_selling_export_updated_price_generate_customer",
      data: 'location_id=' + location_id,
      success: function(data){

      //console.log(data);
      $('.loading').hide();
      $('#van_selling_export_updated_price_generate_customer_page').html(data);

      },
      error: function(error){
        console.log(error);
      }
    });
  });
  
  $("#van_selling_export_updated_price_generate_data").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_export_updated_price_generate_data",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             
             if (data == 'NO_DATA_FOUND') {
               Swal.fire(
                'CANNOT PROCEED',
                'NOTHING TO BE EXPORTED',
                'error'
              )
              $('.loading').hide();
             }else{
                $('#van_selling_export_updated_price_generate_data_page').html(data);
                $('.loading').hide();
             }
          },
        });
    }));


</script>
</body>
</html>
@endsection