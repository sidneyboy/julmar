 @extends('layouts.master')

 @section('title', 'Customer CM For OTHERS')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">CUSTOMER CREDIT MEMO FOR OTHERS</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <form id="proceed_to_summary">
            @csrf
            <div class="row">
              <div class="col-md-3">
                <label>Customer</label>
                  <select class="form-control select2" style="width:100%;" id="customer" name="customer" required>
                    @foreach($customer as $data)
                      <option value="{{ $data->id }}">{{ $data->store_code ." - ". $data->store_name }}</option>
                    @endforeach
                  </select>
              </div>
              <div class="col-md-3">
                <label>Sku Type</label>
                  <select class="form-control select2" style="width:100%;" id="sku_type" name="sku_type" required>
                    <option value="case">Case</option>
                    <option value="butal">Butal</option>
                  </select>
              </div>
              <div class="col-md-3">
                <label>Price Level</label>
                  <select class="form-control select2" style="width:100%;" id="price_level" name="price_level" required>
                    <option value="price_1">Price 1</option>
                    <option value="price_2">Price 2</option>
                    <option value="price_3">Price 3</option>
                    <option value="price_4">Price 4</option>
                  </select>
              </div>

              <div class="col-md-3">
                <label>Principal</label>
                  <select class="form-control select2" style="width:100%;" id="principal" name="principal" required>
                    <option value="" default>Select Principal</option>
                    @foreach($principal as $data)
                      <option value="{{ $data->id }}">{{ $data->principal }}</option>
                    @endforeach
                  </select>
              </div>

              <div class="col-md-12">
                <div id="customer_credit_memo_for_others_show_sku"></div>
              </div>
          </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <div id="customer_credit_memo_for_others_proceed_summary"></div>
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

  $( "#principal" ).change(function() {
    var principal = $(this);
    var sku_type = $('#sku_type');
    //$('.loading').show();
     $.ajax({
        type: "POST",
        url: "customer_credit_memo_for_others_show_sku",
        data: 'principal=' + principal.val() + '&sku_type=' + sku_type.val(),
        success: function(data){
          console.log(data);
       

          if (data == 'no_sku_type') {
            Swal.fire(
              'SKU TYPE NEEDED!',
              'PLEASE SELECT SKU TYPE!!!', 
              'error'
            )
          }else{
            $('#customer_credit_memo_for_others_show_sku').html(data);
            $('.loading').hide();
          }
        }
      })
  });

 $("#proceed_to_summary").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "customer_credit_memo_for_others_proceed_summary",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            //$('.loading').hide();
            $('#customer_credit_memo_for_others_proceed_summary').html(data);
            console.log(data);
          },
        });
    }));





</script>
</body>
</html>
@endsection
























