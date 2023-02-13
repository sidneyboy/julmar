@extends('layouts.master')
@section('title', 'Apply Customer To Agent')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">APPLY CUSTOMER TO AGENT</h3>
    </div>
    <div class="card-body">
      <form id="apply_customer_to_agent_generate_customer">
        <div class="row">
          <div class="col-md-6">
            <label>Agent:</label>
            <select class="form-control select2" required style="width:100%" name="agent" id="agent">
              <option value="" default>Select</option>
              @foreach($agent as $data_agent)
                <option value="{{ $data_agent->id }}">{{ $data_agent->full_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label>Location:</label>
            <select class="form-control select2" required style="width:100%" name="location" id="location">
              <option value="" default>Select</option>
              @foreach($location as $data_location)
                <option value="{{ $data_location->id }}">{{ $data_location->location }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-12">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-info btn-block">PROCEED GENERATE CUSTOMER</button>
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

  // $( "#agent" ).change(function() {
  //   agent = $('#agent').val();
  //   $.post({
  //     type: "POST",
  //     url: "/apply_customer_to_agent_generate_customer",
  //     data: 'agent=' + agent,
  //     success: function(data){

  //     //console.log(data);
  //     $('.loading').hide();
  //     $('#show_customer_data').html(data);

  //     },
  //     error: function(error){
  //       console.log(error);
  //     }
  // });

$("#apply_customer_to_agent_generate_customer").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "apply_customer_to_agent_generate_customer",
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