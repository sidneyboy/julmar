
 @extends('layouts.master')

 @section('title', 'Principal Discount List')

 @section('navbar')


 @section('sidebar')


 @section('content')

 
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
        <h3 class="card-title" style="font-weight: bold;">PRINCIPAL DISCOUNT LIST</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <select name="principal" id="principal" class="form-control select2" style="width:100%;">
                  <option value="" default>Select Principal</option>
                  @foreach ($principals as $data)
                    <option value="{{ $data->id ."=". $data->principal }}">{{ $data->principal }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div id="show_data"></div>
            </div>
          </div>
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
        $('#principal').on('change',function(e){
                var principal = $(this).val();
                
                $.post({
                  type: "POST",
                  url: "/principal_discount_show_data_list",
                  data: 'principal=' + principal,
                  success: function(data){

                    //console.log(data);
                   $('#show_data').html(data);

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
