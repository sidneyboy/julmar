@extends('layouts.master')
@section('title', 'VS RE-INVOICE')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">VAN SELLING RE-INVOICE</h3>
    </div>
    <div class="card-body">
      <form id="van_selling_reinvoice_generate_dr_details">
        <div class="row">
          <div class="col-md-6">
            <label>Date range:</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div>
              <input type="text" class="form-control float-right" id="reservation" required name="date_range">
            </div>
          </div>
          <div class="col-md-6">
            <div id="van_selling_reinvoice_generate_dr_page"></div>
          </div>
        </div>
        <div class="col-md-12">
          <label>&nbsp;</label>
          <button type="submit" style="display: none" id="generate_button" class="btn btn-info btn-block">GENERATE DR DETAILS</button>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="van_selling_reinvoice_generate_dr_details_page"></div>
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

   var hasSuccess = '<?php echo Session::has("error"); ?>';
   if(hasSuccess)
   {
      toastr.error('INCORRECT OM ACCESS KEY!')
   }

  
  $("#van_selling_reinvoice_generate_dr_details").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "van_selling_reinvoice_generate_dr_details",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             $('#van_selling_reinvoice_generate_dr_details_page').html(data);
             $('.loading').hide();
          },
        });
    }));


  $(function() {
    $('input[name="date_range"]').daterangepicker({
      opens: 'left'
    }, function(start, end, label) {
      $('.loading').show();
      var from = start.format('YYYY-MM-DD');
      var to = end.format('YYYY-MM-DD');
    
       $.post({
        type: "POST",
        url: "/van_selling_reinvoice_generate_dr",
        data: 'from=' + from + '&to=' + to,
        success: function(data){

        //console.log(data);
        $('.loading').hide();
        $('#van_selling_reinvoice_generate_dr_page').html(data);
        $('#generate_button').show();
        },
        error: function(error){
          console.log(error);
        }
      })
    });
  });


  


</script>
</body>
</html>
@endsection