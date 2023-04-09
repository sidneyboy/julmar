 @extends('layouts.master')

 @section('title', 'VAN SELLING AR ADJUSTMENTS FORM')

 @section('navbar')


 @section('sidebar')


 @section('content')
     <!-- Main content -->
     <section class="content">

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">VAN SELLING AR ADJUSTMENTS FORM</h3>

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
                 <form id="van_selling_ar_adjustments_proceed">
                     @csrf
                     <div class="row">
                         <div class="col-md-6">
                             <label>SELECT VAN SELLING AGENT:</label>
                             <select class="form-control select2" style="width:100%;" name="customer_id" required>
                                 <option value="" default>SELECT VAN SELLING AGENT</option>
                                 @foreach ($van_selling_agent as $data)
                                     <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                                 @endforeach
                             </select>
                         </div>
                         <div class="col-md-6">
                             <label>ADJUSTMENTS</label>
                             <input type="text" name="ar_adjustments" class="form-control" required>
                         </div>
                         <div class="col-md-12">
                             <label>REMARKS</label>
                             <input type="text" name="remarks" class="form-control" required>
                         </div>
                         <div class="col-md-12">
                             <label>&nbsp;</label>
                             <button type="submit" class="btn btn-block btn-info">PROCEED</button>
                         </div>
                     </div>
                 </form>
             </div>
             <!-- /.card-body -->
             <div class="card-footer">
                 <div id="van_selling_ar_adjustments_proceed_page"></div>
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

         $("#van_selling_ar_adjustments_proceed").on('submit', (function(e) {
             e.preventDefault();
             $('#loader').show();
             $.ajax({
                 url: "van_selling_ar_adjustments_proceed",
                 type: "POST",
                 data: new FormData(this),
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(data) {

                     $('#van_selling_ar_adjustments_proceed_page').html(data);
                     $('#loader').hide();

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
