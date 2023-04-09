 @extends('layouts.master')

 @section('title', 'Customer')

 @section('navbar')


 @section('sidebar')


 @section('content')

     <!-- Main content -->
     <section class="content">
         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">CUSTOMER</h3>
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
                 <form id="customer_save" method="post">
                     @csrf
                     <div class="row">
                         <div class="col-md-4">
                             <label>Store Name</label>
                             <input type="text" class="form-control" name="store_name" required>
                         </div>
                         <div class="col-md-4">
                             <label>Contact Person</label>
                             <input type="text" class="form-control" name="contact_person" required>
                         </div>
                         <div class="col-md-4">
                             <label>Credit Term</label>
                             <select class="form-control select2bs4" name="credit_term" style="width:100%;" required>
                                 <option value="" default>Select Term</option>
                                 <option value="15 days">15 days</option>
                                 <option value="30 days">30 days</option>
                                 <option value="45 days">45 days</option>
                                 <option value="60 days">60 days</option>
                             </select>
                         </div>
                         <div class="col-md-6">
                             <label>Detailed Location</label>
                             <input type="text" name="detailed_location" class="form-control" required>
                         </div>
                         <div class="col-md-6">
                             <label>Credit Line Amount </label>
                             <input type="text" class="form-control" name="credit_line_amount" required
                                 onkeypress="return isNumberKey(event)">
                         </div>

                         <div class="col-md-4">
                             <label>Contact Number</label>
                             <input type="text" class="form-control" name="contact_number" required>
                         </div>
                         <div class="col-md-4">
                             <label>Kind of Business</label>
                             <select class="form-control select2bs4" style="width:100%;" name="kind_of_business" required>
                                 <option vaue="" default>Select KOB</option>
                                 <option value="VAN SELLING">VAN SELLING</option>
                                 <option value="SSS">SSS</option>
                                 <option value="GRO">GRO</option>
                                 <option value="SM">SM</option>
                                 <option value="DS">DS</option>
                                 <option value="PMS">PMS</option>
                                 <option value="CNV">CNV</option>
                                 <option value="HWA">HWA</option>
                                 <option value="WS">WS</option>
                                 <option value="HLS">HLS</option>
                                 <option value="TER">TER</option>
                                 <option value="INST">INST</option>
                             </select>
                         </div>
                         <div class="col-md-4">
                             <label>Location</label>
                             <select class="form-control select2bs4" name="location_id" id="location_id" required
                                 style="width:100%;">
                                 <option value="" default>Select</option>
                                 @foreach ($location as $location_data)
                                     <option value="{{ $location_data->id }}">{{ $location_data->location }}</option>
                                 @endforeach
                             </select>
                         </div>
                         <div class="col-md-12">
                             <div id="customer_show_location_details"></div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group">
                                 <br />
                                 <button type="submit" class="btn btn-success btn-sm float-right">Save New
                                     Customer</button>
                             </div>
                         </div>
                     </div>
                 </form>
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

         $("#customer_save").on('submit', (function(e) {
             e.preventDefault();
             $('#loader').show();
             $.ajax({
                 url: "customer_save",
                 type: "POST",
                 data: new FormData(this),
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(data) {
                     console.log(data);
                     if (data == 'saved') {
                         Swal.fire({
                             position: 'top-end',
                             icon: 'success',
                             title: 'New customer saved, do not forget to add principal code and price level',
                             showConfirmButton: false,
                             timer: 1500
                         })

                         location.reload();
                         $('#loader').hide();

                     } else {
                         Swal.fire(
                             'Something went wrong!',
                             'Redo process or contact system administrator',
                             'error'
                         )
                         $('#loader').hide();
                     }
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
