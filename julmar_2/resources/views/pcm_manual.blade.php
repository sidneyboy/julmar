@extends('layouts.master')
@section('title', 'PCM UPLOAD')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">PCM MANUAL UPLOAD</h3>
    </div>
    <div class="card-body">
      <form id="pcm_manual_generate_dr_details" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Delivery Receipt:</label>
              <input type="text" name="delivery_receipt" style="text-transform: uppercase;" class="form-control" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-info btn-block">GENERATE DR DETAILS</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="pcm_manual_generate_dr_details_page"></div>
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">FINAL SUMMARY</h3>
    </div>
    <div class="card-body">
     <div id="pcm_manual_generate_final_summary_page"></div>
    </div>
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


  $("#pcm_manual_generate_dr_details").on('submit',(function(e){
      e.preventDefault();
      // $('.loading').show();
        $.ajax({
          url: "pcm_manual_generate_dr_details",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            $('.loading').hide();
            $('#pcm_manual_generate_dr_details_page').html(data);
          },
        });
    }));







</script>
</body>
</html>
@endsection