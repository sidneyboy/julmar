@extends('layouts.master')
@section('title', 'VS EXPORT AND PRINT')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">VAN SELLING ADJUSTMENTS EXPORT</h3>
    </div>
    <div class="card-body">
      <form id="van_selling_adjustments_export_generate_data">
        <div class="row">
          <div class="col-md-12">
             <label>CUSTOMER:</label>
             <select class="form-control select2" name="van_selling_adjustments_id" required style="width:100%;">
               <option value="" default>SELECT</option>
               @foreach($van_selling_adjustments as $data)
                <option value="{{ $data->id }}">{{ $data->customer->store_name ." - ". $data->van_selling_printed->delivery_receipt ." - ". $data->date }}</option>
               @endforeach
             </select>
          </div>
          <div class="col-md-12">
              <label>&nbsp;</label>
              <button class="btn btn-info btn-block" type="submit" >GENERATE DR</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="van_selling_adjustments_export_generate_data_page"></div>
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
  
  $("#van_selling_adjustments_export_generate_data").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "van_selling_adjustments_export_generate_data",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             
             $('#van_selling_adjustments_export_generate_data_page').html(data);
                $('.loading').hide();
          },
        });
    }));


</script>
</body>
</html>
@endsection