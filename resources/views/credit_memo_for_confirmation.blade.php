 @extends('layouts.master')

 @section('title', 'CM CONFIRMATION')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">CREDIT MEMO FOR CONFIRMATION</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <form id="search_dr_for_credit_memo_for_confirmation">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>DR CODE</label>
                  <input type="text" name="delivery_receipt" class="form-control" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>&nbsp;</label><br />
                  <button type="submit" class="btn btn-info btn-block">SEARCH DR</button>
                </div>
              </div>
              <div class="col-md-12">
                <div id="credit_memo_for_confirmation_show_dr"></div>
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


      <!-- Default box -->
      {{-- <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">GENERATE FINAL SUMMARY FOR BO</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div id="customer_credit_memo_for_bo_generate_final_summary"></div>
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

 $("#search_dr_for_credit_memo_for_confirmation").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "credit_memo_for_confirmation_show_dr",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            //$('.loading').hide();
                console.log(data);

                $('#credit_memo_for_confirmation_show_dr').html(data);
            // if(data == 'no_dr'){
            //   Swal.fire(
            //      'Non Existing DR, Cannot Proceed!!',
            //      '',
            //      'error'
            //    )
            //   $('.loading').hide();
            // }else if(data == 'no_payment'){
            //   Swal.fire(
            //    'No payment yet, Cannot Proceed!!',
            //    '',
            //    'error'
            //   )
            //   $('.loading').hide();
            // }else if(data == 'okay_na_ang_cm'){
            //   Swal.fire(
            //    'Okay na ang cm, Cannot Proceed!!',
            //    '',
            //    'error'
            //   )
            //   $('.loading').hide();
            // }else{
            //   $('.loading').hide();
            //   $('#customer_credit_memo_for_bo_show_dr_details').html(data);
            // }
          },
        });
    }));





</script>
</body>
</html>
@endsection
























