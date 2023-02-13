@extends('layouts.master')
@section('title', 'Applied Customer To Agent')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">APPLIED CUSTOMER TO AGENT</h3>
    </div>
    <div class="card-body">
      <form id="applied_customer_to_agent_generate_customer_report">
        <div class="row">
          <div class="col-md-12">
            <label>Agent:</label>
            <select class="form-control select2" required style="width:100%" name="agent" id="agent">
              <option value="" default>Select</option>
              @foreach($agent as $data_agent)
                <option value="{{ $data_agent->id }}">{{ $data_agent->full_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-12">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-info btn-block" id="trigger">PROCEED GENERATE CUSTOMER</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="show_customer_data"></div>
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


  $("#applied_customer_to_agent_generate_customer_report").on('submit',(function(e){
        e.preventDefault();
        $('.loading').show();
          $.ajax({
            url: "applied_customer_to_agent_generate_customer_report",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
              console.log(data);
              $('.loading').hide();
              $('#show_customer_data').html(data);
            },
        });
      }));

   

</script>
</body>
</html>
@endsection