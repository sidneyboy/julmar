 @extends('layouts.master')
 @section('title', 'Van Selling Collection')
 @section('navbar')
 @section('sidebar')
 @section('content')

     <!-- Main content -->
     <section class="content">

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">VAN SELLING COLLECTION</h3>

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
                         <button class="btn btn-sm btn-warning float-right" id="short_payment_btn">Short Payment</button>
                         <button class="btn btn-sm btn-dark float-right" id="collection_btn"
                             style="display: none">Collection</button>
                     </div>
                 </div>
                 <div id="collection">
                     <form id="search_store_code_form">
                         @csrf
                         <div class="row">
                             <div class="col-md-6">
                                 <label>Van Selling Agent:</label>
                                 <select class="form-control select2bs4" style="width:100%;" name="customer_id" required>
                                     <option value="" default>Select</option>
                                     @foreach ($customer as $data)
                                         <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="col-md-6">
                                 <label for="">Amount:</label>
                                 <input type="text" class="form-control" required name="amount"
                                     onkeypress="return isNumberKey(event)">
                             </div>
                             <div class="col-md-4">
                                 <label for="">Bank:</label>
                                 <select name="bank" class="form-control" required>
                                     <option value="" default>Select</option>
                                     <option value="BDO">BDO</option>
                                 </select>
                             </div>
                             <div class="col-md-4">
                                 <label for="">Reference #:</label>
                                 <input type="text" name="reference" required class="form-control">
                             </div>
                             <div class="col-md-4">
                                 <label for="">Remarks:</label>
                                 <input type="text" name="remarks" required class="form-control">
                             </div>

                             <div class="col-md-12">
                                 <br />
                                 <button type="submit" class="btn btn-info btn-sm float-right">Generate</button>
                             </div>
                         </div>
                     </form>
                 </div>
                 <div id="short_payment" style="display: none">
                     <form id="van_selling_short_payment_save">
                         <div class="row">
                             <div class="col-md-6">
                                 <label>Van Selling Agent:</label>
                                 <select class="form-control select2bs4" style="width:100%;" name="customer_id" required>
                                     <option value="" default>Select</option>
                                     @foreach ($customer as $data)
                                         <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="col-md-6">
                                 <label for="">Amount:</label>
                                 <input type="text" class="form-control" required name="amount"
                                     onkeypress="return isNumberKey(event)">
                             </div>
                             <div class="col-md-12">
                                 <br />
                                 <button class="btn btn-success float-right btn-sm">Submit</button>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
             <!-- /.card-body -->
             <div class="card-footer">
                 <div id="van_selling_payment_show_accounts_receivable_page"></div>
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

         $("#short_payment_btn").click(function() {
             $('#short_payment').show();
             $('#collection').hide();
             $('#short_payment_btn').hide();
             $('#collection_btn').show();
         });

         $("#collection_btn").click(function() {
             $('#short_payment').hide();
             $('#collection').show();
             $('#short_payment_btn').show();
             $('#collection_btn').hide();
         });

         $("#search_store_code_form").on('submit', (function(e) {
             e.preventDefault();
             $('#loader').show();
             $.ajax({
                 url: "van_selling_payment_search_store_code",
                 type: "POST",
                 data: new FormData(this),
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(data) {
                     if (data == 'NO_DATA') {
                         $('#loader').hide();
                         Swal.fire(
                             'NO DATA FOUND',
                             'NO DR FOR THE MOMENT',
                             'error'
                         )

                     } else {
                         $('#loader').hide();
                         $('#van_selling_payment_show_accounts_receivable_page').html(data);
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

         $("#van_selling_short_payment_save").on('submit', (function(e) {
             e.preventDefault();
             $('#loader').show();
             $.ajax({
                 url: "van_selling_short_payment_save",
                 type: "POST",
                 data: new FormData(this),
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(data) {
                     if (data == 'error') {
                         $('#loader').hide();
                         Swal.fire(
                             'Cannot Proceed',
                             'Amount cannot be greater than short',
                             'error'
                         )
                     } else {
                         $('#loader').hide();
                         Swal.fire(
                             'NO DATA FOUND',
                             'NO DR FOR THE MOMENT',
                             'error'
                         )
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
