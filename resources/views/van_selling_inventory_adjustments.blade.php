 @extends('layouts.master')

 @section('title', 'VS Inventory Adjustments')

 @section('navbar')


 @section('sidebar')


 @section('content')
     <!-- Main content -->
     <section class="content">

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">VAN SELLING INVENTORY ADJUSTMENTS</h3>

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
                 <form id="van_selling_inventory_adjustments_generate">
                     @csrf
                     <div class="row">
                         <div class="col-md-12">
                             <label>SELECT VAN SELLING AGENT:</label>
                             <select class="form-control select2bs4" style="width:100%;" id="customer_id" name="customer_id"
                                 required>
                                 <option value="" default>SELECT VAN SELLING AGENT</option>
                                 @foreach ($van_selling_agent as $data)
                                     <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                                 @endforeach
                             </select>
                         </div>
                         <div class="col-md-12" id="hide_if_proceed">
                             <br />
                             <button type="submit" class="btn btn-info float-right btn-sm">Proceed</button>
                         </div>
                     </div>
                 </form>
             </div>
             <!-- /.card-body -->
             <div class="card-footer">
                 <div id="van_selling_inventory_adjustments_generate_page"></div>
             </div>
             <!-- /.card-footer-->
         </div>
         <!-- /.card -->

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">VAN SELLING INVENTORY ADJUSTMENTS FINAL SUMMARY</h3>

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
                 <div id="van_selling_inventory_adjustments_generate_final_summary_page"></div>
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


         $("#van_selling_inventory_adjustments_generate").on('submit', (function(e) {
             e.preventDefault();
             $('.loading').show();
             $.ajax({
                 url: "van_selling_inventory_adjustments_generate",
                 type: "POST",
                 data: new FormData(this),
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(data) {
                     if (data == 'NO_DATA') {
                         Swal.fire(
                             'NO DATA FOUND',
                             'CANNOT PROCEED!!',
                             'error'
                         )
                         $('.loading').hide();
                     } else if (data == 'sku_ledger_not_yet_cleared') {
                         Swal.fire(
                             'SKU LEDGER NOT YET CLEARED!!',
                             'CANNOT PROCEED!!',
                             'error'
                         )
                         $('.loading').hide();
                     } else {
                         $('.loading').hide();
                         $('#quantity').val('');
                         $("#sku_code").val('').trigger('change')
                         $('#van_selling_inventory_adjustments_generate_page').html(data);
                         $('#remarks').val('');
                     }
                 },
             });
         }));
     </script>
     </body>

     </html>
 @endsection
