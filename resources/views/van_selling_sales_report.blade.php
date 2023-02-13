@extends('layouts.master')
@section('title', 'VS Sales Report')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">VAN SELLING SALES REPORT</h3>
      <a href="{{ url('van_selling_sales_report') }}" class="float-right btn btn-sm btn-warning">REFRESH PAGE</a>
    </div>
    <div class="card-body">
      <form id="van_selling_sales_report_generate">
        <div class="row">
          <div class="col-md-4">
            <label>DATE RANGE:</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div>
              <input type="text" class="form-control float-right" name="date_range" id="reservation">
            </div>
          </div>
          <div class="col-md-4">
           <label>SALESAGENT:</label>
           <select class="form-control select2" required id="customer_id" name="customer_id" style="width:100%;">
             <option value="" default>SELECT SALES AGENT</option>
             <option value="over_all , over_all">OVER ALL</option>
             @foreach($sales_agent as $data)
                <option value="{{ $data->id .",". $data->store_name  }}">{{ $data->store_name }}</option>
             @endforeach
           </select>
          </div>
          <div class="col-md-4">
           <label>SEARCH FOR:</label>
           <select class="form-control select2" required id="search_for" name="search_for" style="width:100%;">
             <option value="" default>SELECT SEARCH FOR</option>
             <option value="search_per_principal">SEARCH PER PRINCIPAL SALES</option>
             <option value="search_per_account">SEARCH PER ACCOUNT SALES</option>
             <option value="search_per_location">SEARCH PER LOCATION</option>
           </select>
          </div>
          <div class="col-md-12">
            <div id="van_selling_sales_report_search_for_page"></div>
          </div>
          <div class="col-md-12">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-info btn-block" id="proceed">PROCEED</button>
            <button type="submit" class="btn btn-success btn-block" id="generate_report" style="display: none">GENERATE REPORT</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="van_selling_sales_report_generate_page"></div>
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

  $("#proceed").click(function() {
      var search_for = $('#search_for').val();
      var customer_id = $('#customer_id').val();
      var reservation = $('#reservation').val();
      $.ajax({
          url: "van_selling_sales_report_search_for",
          type: "POST",
          data:  'search_for=' + search_for + '&customer_id=' + customer_id + '&reservation=' + reservation,
          success: function(data){
            
             if (data == 'input_error') {
              Swal.fire(
                'ERROR INPUT',
                'PLEASE FILL IN ALL INPUT BOX',
                'error'
              )
             }else{
                $('#van_selling_sales_report_search_for_page').html(data);
                $('#generate_report').show();
                $('#proceed').hide();
             }

          },
      });
  });

  $("#van_selling_sales_report_generate").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_sales_report_generate",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             if (data == 'no_data_found') {
              Swal.fire(
                'NO DATA FOUND!',
                'CANNOT PROCEED!',
                'error'
              )
              $('.loading').hide();
             }else if(data == 'cannot_select_all_principal'){
              Swal.fire(
                'CANNOT SELECT ALL PRINCIPAL',
                'CANNOT PROCEED!',
                'error'
              )
              $('.loading').hide();
             }else{
              $('#van_selling_sales_report_generate_page').html(data);
              $('.loading').hide();
             }
          },
        });
    }));
</script>
</body>
</html>
@endsection