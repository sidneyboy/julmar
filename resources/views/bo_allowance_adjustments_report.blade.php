 @extends('layouts.master')

 @section('title', 'Bo Allowance Adjustments Report')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">BO ALLOWANCE ADJUSTMENTS REPORT</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                  </div>
                <input type="text" class="form-control float-right" id="reservation">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <select name="principal" id="principal" class="form-control select2">
                  <option value="" default>Select Principal</option>
                  @foreach ($principals as $data)
                    <option value="{{ $data->id }}">{{ $data->principal }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <button id="generate" class="btn btn-flat btn-success btn-block">GENERATE REPORT</button>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">LIST</h3>
        </div>
        <div class="card-body">
          <div id="show_report_list"></div>
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

     $('#generate').on('click',function(e){
                var date = $('#reservation').val();
                var principal = $('#principal').val();
                $('.loading').show();
                $.post({
                  type: "POST",
                  url: "/bo_allowance_adjustments_generate_report",
                  data: 'date=' + date + '&principal=' + principal,
                  success: function(data){

                    console.log(data);
                    $('.loading').hide();
                    $('#show_report_list').html(data);

                  },
                  error: function(error){
                    console.log(error);
                  }
                });
        });


</script>
</body>
</html>
@endsection
























