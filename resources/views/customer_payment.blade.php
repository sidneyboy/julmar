 @extends('layouts.master')

 @section('title', 'Customer Payment')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">CUSTOMER PAYMENT</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
        <form id="search_store_code_form">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <label>Search for</label>
                <select class="form-control select2" name="search_for" required style="width:100%;">
                  <option value="" default>SELECT</option>
                  <option value="STORE_CODE">STORE CODE</option>
                  <option value="PRINCIPAL">PRINCIPAL</option>
                  <option value="DELIVERY_RECEIPT">DELIVERY RECEIPT</option>
                </select>
              </div>
              <div class="col-md-6">
                <label>Search:</label>
                <input type="text" name="search" class="form-control" require>
              </div>
              
              <div class="col-md-12">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-info btn-block">SEARCH STORE CODE</button>
              </div>
            </div>
          </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
         <div id="customer_payment_show_accounts_receivable_page"></div>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

      <!-- Default box -->
      <div class="card">
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
          <div id="customer_payment_generate_summary_page"></div>
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

 $("#search_store_code_form").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "customer_payment_search_store_code",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            
            console.log(data);
            if(data == 'NO_DATA'){
               Swal.fire(
              'NO DATA FOUND',
              'NO DR FOR THE MOMENT',
              'error'
              )
              $('.loading').hide(); 
            }else{
              $('.loading').hide();
              $('#customer_payment_show_accounts_receivable_page').html(data);
            }
          },
        });
    }));





</script>
</body>
</html>
@endsection
























