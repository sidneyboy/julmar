 @extends('layouts.master')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">LOCATION</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
               <form id="submit_location" method="post">
                <div class="form-group">
                  <label>New Location</label>
                  <input type="text" name="location" class="form-control" required>
                </div>
                <div class="form-group">
                  <input type="submit" value="SUBMIT" class="btn btn-block btn-success" />
                </div>
              </form>
            </div>
            <div class="col-md-8">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>LOCATION</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($location as $data)
                    <tr>
                      <td>{{ $data->id }}</td>
                      <td>{{ $data->location }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
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
  
  $("#submit_location").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "location_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            if(data == 'saved'){
              toastr.success('SUCCESSFULLY ADDED NEW LOCATION')
              location.reload();
            }else{
              toastr.error('ERROR')
              $('.loading').hide();
            }
          },
      });
    }));

</script>
</body>
</html>
@endsection
























