 @extends('layouts.master')
 @section('title', 'Subsidy')
 <style type="text/css">
   .ui-datepicker-calendar {
    display: none;
    }
 </style>
 @section('navbar')
 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">SUBSIDNEY</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <form>
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <label>FOR THE MONTH OF</label>
                <input type="month" name="" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label>Type of Allowance:</label>
                <select class="form-control select2" style="width:100%;" required>
                  <option value="" default>Select Allowance</option>
                  <option value="">Merchandising Subsidy</option>
                  <option value="">Display Allowance</option>
                  <option value="">Bo Holliday</option>
                </select>
              </div>
              <div class="col-md-6">
                <label>Amount</label>
                <input type="text" class="currency-default" style="display: block;
                width: 100%;
                height: calc(2.25rem + 2px);
                padding: .375rem .75rem;
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                color: #495057;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #ced4da;
                border-radius: .25rem;
                box-shadow: inset 0 0 0 transparent;
                transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;" required>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" class="btn btn-info btn-block">GENERATE DATA</button>
          </div>
        </form>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

 @endsection

 
@section('footer')
  @parent

<script>

    $('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  
  // $("#received_id" ).change(function() {
  //    var received_id = $(this).val(); 
  //    $('.loading').show();       
  //     $.post({
  //     type: "POST",
  //     url: "/bo_allowance_adjustments_inputs",
  //     data: 'received_id=' + received_id,
  //     success: function(data){

  //     //console.log(data);
  //     $('.loading').hide();
  //     $('#show_bo_allowance_adjustments').html(data);

  //     },
  //     error: function(error){
  //       console.log(error);
  //     }
  //   });
  // });




  $("#bo_allowance_total_generate").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
       //$('#sales_order_migrate_summary_page').show();
        $.ajax({
          url: "bo_allowance_total_generate_page",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){

            $('#bo_allowance_total_generate_page').html(data);
            
            // if(data == 'existing sales_order_number'){
            //    Swal.fire(
            //   'Existing Sales Order Number, Cannot Proceed!!',
            //   '',
            //   'error'
            //   )
            //   $('.loading').hide(); 
            // }else{
            //   $('.loading').hide();

            //   $('#sales_order_migrate_summary_page').html(data);
            // }
          },
        });
    }));

</script>
</body>
</html>
@endsection
























