 @extends('layouts.master')

 @section('title', 'Receive Order')

 @section('navbar')


 @section('sidebar')


 @section('content')

     <section class="content">

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">RECEIVED ORDER</h3>

                 <button class="btn btn-warning btn-flat float-right" style="display: none;" id="reload_page"
                     onclick="return reload_page()">RELOAD FOR NEW TRANSACTION</button>
             </div>
             <div class="card-body">
                 <form id="receive_order_generate_data">
                     @csrf
                     <div class="row">
                         <div class="col-md-3">
                             <label>Receive ID:</label>
                             <div class="form-group">
                                 <input type="text" class="form-control" style="border-radius: 0px;text-align: center;" value="{{ $id }}" disabled>
                             </div>
                         </div>
                         <div class="col-md-3">
                             <label>Purchase Order #:</label>
                             <div class="form-group">
                                 <select class="form-control select2bs4" name="purchase_id" id="purchase_id"
                                     style="width:100%;" required>
                                     <option value="" default>Select PO</option>
                                     @foreach ($purchase_id as $data)
                                         <option
                                             value="{{ $data->id . '=' . $data->skuPrincipal->principal . '=' . $data->purchase_id . '=' . $data->skuPrincipal->id }}">
                                             {{ $data->purchase_id }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group">
                                 <label>Freight cost:</label>
                                 <input type="text" name="freight" id="freight" class="currency-default"
                                     placeholder="Freight Cost...."
                                     style="display: block;
                width: 100%;
                height: 34px;
                padding: 6px 12px;
                font-size: 14px;
                line-height: 1.42857143;
                color: #555;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 0px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;width:100%;"
                                     required>
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label>Branch</label>
                                 <select class="form-control" name="branch" style="width:100%;">
                                     <option value="" default>Select Branch</option>
                                     <option value="NORTH MIN">NORTH MIN</option>
                                     <option value="CARAGA">CARAGA</option>
                                     <option value="POD">POD</option>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label>Truck #:</label>
                                 <input type="text" name="truck_number" class="form-control" placeholder="Truck No.."
                                     style="border-radius: 0px;text-transform: uppercase;" required>
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label>Dr / Si | Driver Name:</label>
                                 <input type="text" name="dr_si" id="dr_si" class="form-control"
                                     placeholder="DR/SI OR DRIVER NAME"
                                     style="border-radius: 0px;text-transform: uppercase;" required>
                                 <i id="drsiError" style="color:red;display: none;">**** Existing Dr / Si</i>
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label>Invoice Date:</label>
                                 <div class="input-group">
                                     <div class="input-group-prepend">
                                         <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                     </div>
                                     <input type="date" class="form-control" name="invoice_date">
                                 </div>
                                 <!-- /.input group -->
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label>Courier:</label>
                                 <select class="form-control" name="courier" id="courier"
                                     style="border-radius: 0px;width: 100%;" required>
                                     <option value="" default>Select Courier</option>
                                     <option value="SOLID">SOLID</option>
                                     <option value="MORETA">MORETA</option>
                                     <option value="NONE">NONE</option>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group">
                                 <button class="btn btn-info btn-sm btn-block" type="submit">Proceed</button>
                             </div>
                         </div>
                     </div>
                 </form>
             </div>
             <!-- /.card-body -->
             <div class="card-footer">

             </div>
             <!-- /.card-footer-->
         </div>
         <!-- /.card -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">DATA SUMMARY</h3>
             </div>
             <div class="card-body">
                 <div id="show_data_summary"></div>
             </div>
         </div>

         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">DATA SUMMARY</h3>
             </div>
             <div class="card-body">
                 <div id="show_data_final_summary"></div>
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

         //  function generate_data() {

         //      var form = document.myform;
         //      var dataString = $(form).serialize();
         //      $('.loading').show();
         //      $.ajax({
         //          type: 'POST',
         //          url: '/receive_order_generate_data',
         //          data: dataString,
         //          success: function(data) {
         //              $('.loading').hide();
         //              $('#show_data_summary').html(data);
         //              // $('.generate_data').prop('disabled', true);
         //              $('#reload_page').show();
         //          }
         //      });
         //      return false;
         //  }



         $("#receive_order_generate_data").on('submit', (function(e) {
             e.preventDefault();
             //$('.loading').show();
             $('#hide_if_trigger').hide();
             $.ajax({
                 url: "receive_order_generate_data",
                 type: "POST",
                 data: new FormData(this),
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(data) {
                     console.log(data);
                     $('.loading').hide();
                     $('#show_data_summary').html(data);
                     // $('.generate_data').prop('disabled', true);
                     $('#reload_page').show();
                 },
             });
         }));


         function reload_page() {
             $('.loading').show();
             location.reload();
         }
     </script>

     </body>

     </html>
 @endsection
