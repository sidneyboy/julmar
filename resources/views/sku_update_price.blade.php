 @extends('layouts.master')

 @section('title', 'Price Update')

 @section('navbar')


 @section('sidebar')


 @section('content')
     <!-- Main content -->
     <section class="content">

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">SKU PRICE UPDATE</h3>

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
                 <div class="row">
                     <div class="col-md-12">
                         <div class="form-group">
                             <label>Principal</label>
                             <select class="form-control" name="principal" style="width:100%;" id="principal">
                                 <option value="" default>Select</option>
                                 @foreach ($principal as $data)
                                     <option value="{{ $data->id . '-' . $data->principal }}">{{ $data->principal }}
                                     </option>
                                 @endforeach
                             </select>
                         </div>
                     </div>
                     <div class="col-md-12">
                         <div id="sku_update_price_show_sku"></div>
                     </div>
                 </div>
             </div>
             <!-- /.card-body -->
             <div class="card-footer">
                 <div id="sku_update_price_generate_price_inputs"></div>
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

         $("#principal").change(function() {
             var principal = $(this).val();
             $('#loader').show();       
             $.post({
                 type: "POST",
                 url: "sku_update_price_show_sku",
                 data: 'principal=' + principal,
                 success: function(data) {
                     $('#loader').hide();
                     $('#sku_update_price_show_sku').html(data);

                 },
                 error: function(error) {
                     Swal.fire(
                         'Cannot Proceed',
                         'Please Contact IT Support',
                         'error'
                     )
                 }
             });
         });
     </script>
     </body>

     </html>
 @endsection
