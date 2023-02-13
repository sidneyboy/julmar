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
      <h3 class="card-title" style="font-weight: bold;">PCM UPLOAD</h3>
    </div>
    <div class="card-body">
      <form id="pcm_upload_save" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputFile">File input</label>
              <input type="file" name="agent_csv_file" required class="form-control">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <input type="submit" value="UPLOAD AGENT PCM" id="upload_agent_sales_order" class="btn btn-block btn-success" />
            </div>
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


  $("#pcm_upload_save").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "pcm_upload_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            if(data == 'wrong_file_input'){
               Swal.fire(
                'Cannot Proceed!!',
                'Wrong File Input',
                'error'
              )
              $('.loading').hide(); 
            }else if(data == 'existing_export_code'){
              Swal.fire(
                'Cannot Proceed!!',
                'Existing file',
                'error'
              )
              $('.loading').hide(); 
            }else if(data == 'unregistered_agent_id'){
              Swal.fire(
                'Cannot Proceed!!',
                'Unregistered Agent ID',
                'error'
              )
              $('.loading').hide(); 
            }else if(data == 'no_dr'){
              Swal.fire(
                'Cannot Proceed!!',
                'No Dr',
                'error'
              )
              $('.loading').hide(); 
            }else if(data == 'saved'){
               Swal.fire(
                'Data Uploaded Successfully',
                'Success',
                'success'
              )
              $('.loading').hide();
              document.getElementById("pcm_upload_save").reset(); 
            }
          },
        });
    }));







</script>
</body>
</html>
@endsection