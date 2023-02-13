@extends('layouts.master')
@section('title', 'VS PRICE DIFF')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">VAN SELLING PRICE DIFFERENCE</h3>
    </div>
    <div class="card-body">
      <form id="van_selling_price_difference_generate" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
          <div class="col-md-6">
            <label>Date Range:</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div>
              <input type="text" class="form-control float-right" name="date_range" id="reservation">
            </div>
          </div>
          <div class="col-md-6">
            <label>Principal:</label>
            <select class="form-control select2" style="width:100%;" required name="principal_id" id="principal_id">
              <option value="" default>SELECT</option>
              @foreach($principal as $data)
                <option value="{{ $data->id .",". $data->principal }}">{{ $data->principal }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-12">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-block btn-info">GENERATE DATA</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="van_selling_price_difference_generate_page"></div>
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">VAN SELLING PRICE DIFFERENCE FINAL SUMMARY </h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div id="van_selling_price_difference_generate_final_summary_page"></div>
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

  $("#van_selling_price_difference_generate").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_price_difference_generate",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             $('#van_selling_price_difference_generate_page').html(data);
               $('.loading').hide();
          },
        });
    }));
</script>
</body>
</html>
@endsection