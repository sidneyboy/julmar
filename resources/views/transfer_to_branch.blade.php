 @extends('layouts.master')

 @section('title', 'Transfer to Branch')

 @section('navbar')


 @section('sidebar')


 @section('content')

     <!-- Main content -->
     <section class="content">

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">TRANSFER SKU TO BRANCH</h3>

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
                 <form id="transfer_to_branch_show_input">
                     <div class="row">
                         <div class="col-md-6">
                             <label>PO #:</label>
                             <select name="received_id" id="received_id" class="form-control select2bs4"
                                 style="width:100%;">
                                 <option value="" default>Select</option>
                                 @foreach ($received as $data)
                                     <option
                                         value="{{ $data->id . '=' . $data->principal_id . '=' . $data->purchase_order->purchase_id . '=' . $data->dr_si . '=' . $data->remarks }}">
                                         {{ 'PO #: ' . $data->purchase_order->purchase_id }} / BRANCH: {{ $data->branch }}
                                     </option>
                                 @endforeach
                             </select>
                         </div>
                         <div class="col-md-6">
                             <label>Transfer To:</label>
                             <select name="transfer_to_branch" class="form-control" required>
                                 <option value="" default>Select</option>
                                 <option value="NORTH MIN">NORTH MIN</option>
                                 <option value="CARAGA">CARAGA</option>
                                 <option value="POD">POD</option>
                             </select>
                         </div>
                     </div>
                     <br />
                     <input type="hidden" name="sku_type" value="{{ $received[0]->purchase_order->sku_type }}">
                     <button class="btn btn-sm float-right btn-info">Proceed</button>
                 </form>
             </div>
             <!-- /.card-body -->
             <div class="card-footer">
                 <div id="show_return_inputs"></div>
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

         $("#transfer_to_branch_show_input").on('submit', (function(e) {
             e.preventDefault();
             $('#loader').show();
             $.ajax({
                 url: "transfer_to_branch_show_input",
                 type: "POST",
                 data: new FormData(this),
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(data) {
                     $('#show_return_inputs').html(data);
                     $('#loader').hide();
                 },
                 error: function(error) {
                     Swal.fire(
                         'Cannot Proceed',
                         'Please Contact IT Support',
                         'error'
                     )
                     $('#loader').hide();
                 }
             });
         }));
     </script>
     </body>

     </html>
 @endsection
