 @extends('layouts.master')

 @section('title', 'Purchase Order Report')

 @section('navbar')


 @section('sidebar')


 @section('content')

     <!-- Main content -->
     <section class="content">

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">PURCHASE ORDER REPORT</h3>

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
                     <div class="col-md-6">
                         <div class="input-group">
                             <div class="input-group-prepend">
                                 <span class="input-group-text">
                                     <i class="far fa-calendar-alt"></i>
                                 </span>
                             </div>
                             <input type="text" class="form-control float-right" id="reservation">
                         </div>
                     </div>
                     <div class="col-md-6">
                         <button type="button" class="btn btn-success btn-block" id="generate">Generate</button>
                     </div>
                 </div>
             </div>
             <!-- /.card-body -->
             <div class="card-footer">

             </div>
             <!-- /.card-footer-->
         </div>
         <!-- /.card -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">LIST</h3>
             </div>
             <div class="card-body">
                 <div id="show_report_list"></div>
             </div>
         </div>

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

         var hasSuccess = '<?php echo Session::has('success'); ?>';
         if (hasSuccess) {
             toastr.success('Purchase Order Updated')
         }

         $('#generate').on('click', function(e) {
             var date = $('#reservation').val();
             $('#loader').show();
             $.post({
                 type: "POST",
                 url: "/purchase_order_report_show_list",
                 data: 'date=' + date,
                 success: function(data) {

                     $('#loader').hide();
                     $('#show_report_list').html(data);

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
