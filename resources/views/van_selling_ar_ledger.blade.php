 @extends('layouts.master')

 @section('title', 'VS')

 @section('navbar')


 @section('sidebar')


 @section('content')

     <!-- Main content -->
     <section class="content">

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">VAN SELLING AR LEDGER</h3>

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
                 <form id="van_selling_ar_ledger_generate_data">
                     @csrf
                     <div class="row">
                         <div class="col-md-6">
                             <label>Date Range:</label>
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                     <span class="input-group-text">
                                         <i class="far fa-calendar-alt"></i>
                                     </span>
                                 </div>
                                 <input type="text" class="form-control float-right" id="reservation" name="date_range"
                                     required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <label>Select Agent:</label>
                             <select class="form-control select2bs4" name="customer_id" style="width:100%;"
                                 id="customer_id">
                                 <option value="" default>SELECT</option>
                                 @foreach ($customer as $data)
                                     <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                                 @endforeach
                             </select>
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
                 <div id="van_selling_ar_ledger_generate_data_page"></div>
             </div>
             <!-- /.card-footer-->
         </div>
         <!-- /.card -->

         <!-- Default box -->

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

         $("#van_selling_ar_ledger_generate_data").on('submit', (function(e) {
             e.preventDefault();
             $('#loader').show();
             $('#hide_if_trigger').hide();
             $.ajax({
                 url: "van_selling_ar_ledger_generate_data",
                 type: "POST",
                 data: new FormData(this),
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(data) {
                     $('#loader').hide();
                     $('#van_selling_ar_ledger_generate_data_page').html(data);
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
