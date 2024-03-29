 @extends('layouts.master')

 @section('title', 'Invoice Cost Adjustments')

 @section('navbar')


 @section('sidebar')


 @section('content')

     <!-- Main content -->
     <section class="content">

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">INVOICE COST ADJUSTMENTS</h3>

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
                 <div class="form-group">
                     <label>DR #</label>
                     <select name="received_id" id="received_id" class="form-control select2bs4" style="width:100%;">
                         <option value="" default>Select DR</option>
                         @foreach ($received_data as $data)
                             <option
                                 value="{{ $data->id . '=' . $data->principal_id . '=' . $data->purchase_order->purchase_id . '=' . $data->dr_si }}">
                                 {{ 'RR - ' . $data->id . ' | POID ' . $data->purchase_order->purchase_id }}</option>
                         @endforeach
                     </select>
                 </div>
                 <div id="show_invoice_cost_adjustments"></div>
             </div>
             <!-- /.card-body -->
             <div class="card-footer">
                 <div id="show_invoice_cost_adjustments_summary"></div>
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

         $("#received_id").change(function() {
             var received_id = $(this).val();
             $('#loader').show();
             $.post({
                 type: "POST",
                 url: "/invoice_cost_adjustments_input",
                 data: 'received_id=' + received_id,
                 success: function(data) {
                     $('#loader').hide();
                     $('#show_invoice_cost_adjustments').html(data);
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
         });
     </script>
     </body>

     </html>
 @endsection
