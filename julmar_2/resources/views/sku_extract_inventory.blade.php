@extends('layouts.master')
@section('title', 'Extract Sku Inventory')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">EXTRACT SKU INVENTORY</h3>
    </div>
    <div class="card-body">
      <form id="extract_sku_inventory_generate_data">
        <div class="row">
          <div class="col-md-4">
            <label>Principal:</label>
            <select class="form-control select2bs4" required style="width:100%" name="principal">
              <option value="" default>Select</option>
              @foreach($principal as $data)
                <option value="{{ $data->id }}">{{ $data->principal }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label>Extract For?</label>
            <select name="extract_for" class="form-control select2bs4" style="width:100%;" required>
              <option value="" default>Select</option>
              <option value="REGULAR EXTRACT">REGULAR EXTRACT</option>
              <option value="BOOKING">BOOKING</option>
              <option value="VAN SELLING">VAN SELLING</option>
            </select>
          </div>
          <div class="col-md-4">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-info btn-block">Generate SKU Inventory</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="extract_sku_inventory_generate_data_page"></div>
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">SKU TO BE EXPORTED</h3>
    </div>
    <div class="card-body">
      <div id="extract_sku_inventory_generate_export_data_page"></div>
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

$("#extract_sku_inventory_generate_data").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "extract_sku_inventory_generate_data",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            $('#extract_sku_inventory_generate_data_page').html(data);
            $('.loading').hide();
          },
      });
    }));
</script>
</body>
</html>
@endsection