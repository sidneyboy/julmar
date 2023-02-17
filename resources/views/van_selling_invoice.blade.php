@extends('layouts.master')
@section('title', 'VS EXPORT AND PRINT')
@section('navbar')
@section('sidebar')
@section('content')

<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">VAN SELLING INVENTORY EXPORT AND PRINT</h3>
    </div>
    <div class="card-body">
      <form id="van_selling_invoice_generate">
        <div class="row">
          <div class="col-md-12">
             <label>VAN SELLING DR:</label>
             <select class="form-control select2bs4" name="van_selling_id" required style="width:100%;">
               <option value="" default>SELECT</option>
               @foreach($van_selling as $data)
                <option value="{{ $data->id }}">{{ $data->delivery_receipt ." - [". $data->customer->store_name ."]" }}</option>
               @endforeach
             </select>
          </div>
          <div class="col-md-12">
              <br />
              <button class="btn btn-info btn-sm float-right" type="submit" >Generate</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="van_selling_invoice_generate_page"></div>
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
  
  $("#van_selling_invoice_generate").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_invoice_generate",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             $('#van_selling_invoice_generate_page').html(data);
          },
        });
    }));

  


</script>
</body>
</html>
@endsection