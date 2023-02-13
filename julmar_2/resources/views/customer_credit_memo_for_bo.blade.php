 @extends('layouts.master')

 @section('title', 'Customer CM For BO')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">CUSTOMER CREDIT MEMO FOR BO</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <form id="search_dr_for_credit_memo">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>PCM #</label>
                  <input type="text" style="text-transform: uppercase;" name="pcm_number" class="form-control" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>&nbsp;</label><br />
                  <input type="hidden" name="posted_by" value="{{ $employee_name->name }}">
                  <button type="submit" class="btn btn-info btn-block">SEARCH DR</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <div id="customer_credit_memo_for_bo_show_dr_details"></div>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->


      <!-- Default box -->
      <div class="card">
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

 $("#search_dr_for_credit_memo").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "customer_credit_memo_for_bo_show_dr_details",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            //$('.loading').hide();
                    
            if(data == 'non_existing_pcm_number'){
              Swal.fire(
                 'NONE EXISTING PCM NUMBER, CANNOT PROCEED!!',
                 '',
                 'error'
               )
              $('.loading').hide();
            }else if(data == 'posted'){
              Swal.fire(
               'CREDIT MEMO ALREADY POSTED, CANNOT PROCEED',
               '',
               'error'
              )
              $('.loading').hide();
            }else{
              $('.loading').hide();
              $('#customer_credit_memo_for_bo_show_dr_details').html(data);
            }
          },
        });
    }));





</script>
</body>
</html>
@endsection
























