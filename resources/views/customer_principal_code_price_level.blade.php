 @extends('layouts.master')

 @section('title', 'Customer Principal Code')

 @section('navbar')


 @section('sidebar')


 @section('content')

     <!-- Main content -->
     <section class="content">
         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">CUSTOMER PRINCIPAL CODE</h3>
                 <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                         title="Collapse">
                         <i class="fas fa-minus"></i></button>
                     <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                         title="Remove">
                         <i class="fas fa-times"></i></button>
                 </div>
             </div>
             <div class="card-body">
                 <form id="customer_principal_code_price_level_proceed">
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Customer:</label>
                                 <select class="form-control select2bs4" required name="customer" style="width:100%;">
                                     <option value="" default>Select</option>
                                     @foreach ($customer as $data)
                                         <option value="{{ $data->id . ',' . $data->store_name }}">
                                             {{ $data->store_name . ' - ' . $data->location->location }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>&nbsp;</label>
                                 <button type="submit" class="btn btn-info btn-block">PROCEED</button>
                             </div>
                         </div>
                     </div>
                 </form>
             </div>
             <!-- /.card-body -->
             <div class="card-footer">
                 <div id="customer_principal_code_price_level_proceed_page"></div>
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

         $("#customer_principal_code_price_level_proceed").on('submit', (function(e) {
             e.preventDefault();
             $('#loader').show();
             $.ajax({
                 url: "customer_principal_code_price_level_proceed",
                 type: "POST",
                 data: new FormData(this),
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(data) {
                    $('#loader').hide();
                     $('#customer_principal_code_price_level_proceed_page').html(data);
                 },
                 error: function(error) {
                    $('#loader').hide();
                     Swal.fire(
                         'Cannot Proceed',
                         'Please Contact IT Support',
                         'error'
                     )
                 }
             });
         }));
     </script>
     </body>

     </html>
 @endsection
