@extends('layouts.master')
@section('title', 'PCM VS POST')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">PCM VAN SELLING FOR POSTING</h3>
    </div>
    <div class="card-body">
      <form id="van_selling_pcm_post_generate" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
          <div class="col-md-12">
            <label>VAN SELLING PCM #:</label>
            <input type="text" name="pcm_number" class="form-control" required>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="">&nbsp;</label>
              <input type="submit" value="GENERATE" id="upload_agent_sales_order" class="btn btn-block btn-info" />
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="van_selling_pcm_post_generate_page"></div>
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


  $("#van_selling_pcm_post_generate").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_pcm_post_generate",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            if (data == 'No_such_pcm_number') {
              $('.loading').hide();
              Swal.fire(
                'No Data Found!!',
                'Cannot Proceed!',
                'error'
              )
            }else if(data == 'Pcm_number_already_posted'){
              $('.loading').hide();
              Swal.fire(
                'Pcm_number_already_posted!',
                'Cannot Proceed!',
                'error'
              )
              $('.loading').hide();
            }else{
              $('.loading').hide();
              $('#van_selling_pcm_post_generate_page').html(data);
            }
          },
        });
    }));







</script>
</body>
</html>
@endsection