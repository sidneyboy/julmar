@extends('layouts.master')
@section('title', 'PCM UPLOAD REPORT')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">PCM UPLOAD REPORT</h3>
    </div>
    <div class="card-body">
      <form id="pcm_upload_report_generate" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Agent:</label>
              <select class="form-control select2" required name="agent_id" style="width:100%;">
                <option value="" default>SELECT AGENT</option>
                @foreach($agent as $data)
                  <option value="{{ $data->id }}" style="text-transform: uppercase;">{{ $data->full_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <input type="hidden" name="employee_name" value="{{ $employee_name->name }}">
              <button type="submit" class="btn btn-info btn-block">GENERATE DATA</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="pcm_upload_report_generate_page"></div>
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">PCM DETAILS</h3>
    </div>
    <div class="card-body">
      <div id="pcm_upload_report_generate_details_page"></div>
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


  $("#pcm_upload_report_generate").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "pcm_upload_report_generate",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            $('.loading').hide();
            $('#pcm_upload_report_generate_page').html(data);
          },
        });
    }));







</script>
</body>
</html>
@endsection