
 @extends('layouts.master')

 @section('title', 'Bodega Out')

 @section('navbar')


 @section('sidebar')


 @section('content')

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
        <h3 class="card-title" style="font-weight: bold;">BODEGA OUT</h3>

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
                <div class="form-group">
                  <label>SKU Type:</label>
                  <select name="uom" id="uom" class="form-control" style="width: 100%;">
                    <option value="" default>Select UOM</option>
                    <option value="Case">Case</option>
                    <option value="Butal">Butal</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Principal:</label>
                  <select name="principal" id="principal" class="form-control" style="width: 100%;">
                    <option value="" default>Select Principal</option>
                    @foreach($principals as $data)
                    <option value="{{ $data->id ."=". $data->principal }}">{{ $data->principal }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <button class="btn btn-sm btn-info float-right" id="proceed">Proceed</button>
                </div>
              </div>
              <div class="col-md-12">
                <div id="show_input"></div>
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
        <h3 class="card-title" style="font-weight: bold;">SUMMARY</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
           <div id="show_bodega_out_summary"></div>
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
        

   

        $('#proceed').on('click',function(e){
                var uom = $('#uom').val();
                var principal = $('#principal').val();
                $('.loading').show();
                $.post({
                  type: "POST",
                  url: "/bodega_out_show_input",
                  data: 'uom=' + uom + '&principal=' + principal,
                  success: function(data){

                   if (data == 'no_input') {
                     $('.loading').hide();
                      Swal.fire(
                      'CANNOT PROCEED!',
                      'PRINCIPAL AND UOM FIELD ARE NEEDED',
                      'error'
                      )
                   }else{
                     $('.loading').hide();
                     $('#show_input').html(data);
                   }

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
