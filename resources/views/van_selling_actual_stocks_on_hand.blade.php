 @extends('layouts.master')

 @section('title', 'VS Stocks on hand')

 @section('navbar')


 @section('sidebar')


 @section('content')

     <!-- Main content -->
     <section class="content">

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">VAN SELLING ACTUAL STOCKS ON HAND</h3>

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
                 <form id="van_selling_actual_stocks_on_hand_proceed">
                     @csrf
                     <div class="row">
                         <div class="col-md-6">
                             <label>Agent:</label>
                             <select class="form-control select2bs4" style="width:100%;" name="store_id" required>
                                 <option value="" default>Select</option>
                                 @foreach ($van_selling_agent as $data)
                                     <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                                 @endforeach
                             </select>
                         </div>
                         <div class="col-md-6">
                             <label for="">Actual Stocks on Hand</label>
                             <input type="text" onkeypress="return isNumberKey(event)" name="actual_stocks_on_hand" class="form-control">
                         </div>
                         <div class="col-md-12">
                             <br />
                             <button type="submit" class="btn btn-info btn-sm float-right">Generate</button>
                         </div>
                     </div>
                 </form>
             </div>
             <!-- /.card-body -->
             <div class="card-footer">
                 <div id="van_selling_actual_stocks_on_hand_proceed_page"></div>
             </div>
             <!-- /.card-footer-->
         </div>
         <!-- /.card -->

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">CUSTOMER PAYMENT SUMMARY</h3>

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
                 <div id="van_selling_actual_stocks_on_hand_final_summary_page"></div>
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

         function isNumberKey(evt) {
             var charCode = (evt.which) ? evt.which : evt.keyCode;
             if (charCode != 46 && charCode > 31 &&
                 (charCode < 48 || charCode > 57))
                 return false;

             return true;
         }

         $("#van_selling_actual_stocks_on_hand_proceed").on('submit', (function(e) {
             e.preventDefault();
             $('.loading').show();
             $.ajax({
                 url: "van_selling_actual_stocks_on_hand_proceed",
                 type: "POST",
                 data: new FormData(this),
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(data) {

                     $('.loading').hide();
                     $('#van_selling_actual_stocks_on_hand_proceed_page').html(data);
                 },
             });
         }));
     </script>
     </body>

     </html>
 @endsection
