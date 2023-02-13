 @extends('layouts.master')

 @section('title', 'VAN SELLING PRICE ADJUSTMENTS FORM')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">VAN SELLING PRICE ADJUSTMENTS FORM</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
        <form id="van_selling_price_adjustments_save">
            @csrf
            <div class="row">
              <div class="col-md-6">
               {{--  <label>Search for</label>
                <input type="text" style="text-transform: uppercase;" name="store_code" class="form-control" placeholder="Store Code" required> --}}
                <label>SELECT VAN SELLING AGENT:</label>
                <select class="form-control select2" style="width:100%;" name="customer_id" required>
                  <option value="" default>SELECT VAN SELLING AGENT</option>
                  @foreach($van_selling_agent as $data)
                    <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label>PRICE ADJUSTMENTS:</label>
                <input type="text" name="price_adjustments" class="form-control" required>
              </div>
              <div class="col-md-12">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-block btn-success">SUBMIT</button>
              </div>
            </div>
          </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
         <div id="van_selling_submit_page"></div>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

      <!-- Default box -->
      {{-- <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">CUSTOMER PAYMENT SUMMARY</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div id="van_selling_submit_final_summary_page"></div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
         
        </div>
        <!-- /.card-footer-->
      </div> --}}
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

 $("#van_selling_price_adjustments_save").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "van_selling_price_adjustments_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            
            console.log(data);
            if (data == 'saved') {
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
              })

              location.reload();
                  }else{
                    Swal.fire(
                'SOMETHING WENT WRONG!',
                'PLEASE CONTACT ADMIN',
                'ERROR'
              )
              $('.loading').hide();
            }
          },
        });
    }));





</script>
</body>
</html>
@endsection
























