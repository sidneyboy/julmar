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
             <!-- /.card-body -->
             <div class="card-footer">
                 <div class="table table-responsive">
                     <table class="table table-bordered table-hover" id="example1">
                         <thead>
                             <tr>
                                 <th colspan="" rowspan="" headers="" scope="">ID</th>
                                 <th style="text-align: center;">STORE NAME</th>
                                 <th style="text-align: center;">KOB</th>
                                 <th style="text-align: center;">CREDIT TERM</th>
                                 <th style="text-align: center;">CREDIT<br />LINE<br />AMOUNT</th>
                                 <th style="text-align: center;">LOCATION</th>
                                 <th style="text-align: center;">BRGY/PUROK/SITIO</th>
                                 <th style="text-align: center;">DETAILED<br />LOCATION</th>
                                 <th style="text-align: center;">CONTACT<br />PERSON</th>
                                 <th style="text-align: center;">CONTACT<br />NUMBER</th>
                                 <th style="text-align: center;">ADDITIONAL<br />INFORMATION</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($customer as $data)
                                 <tr>
                                     <td style="text-align: center;text-transform: uppercase;">{{ $data->id }}</td>
                                     <td style="text-align: center;text-transform: uppercase;">{{ $data->store_name }}</td>
                                     <td style="text-align: center;text-transform: uppercase;">
                                         {{ $data->kind_of_business }}</td>
                                     <td style="text-align: center;text-transform: uppercase;">{{ $data->credit_term }}
                                     </td>
                                     <td style="text-align: center;text-transform: uppercase;">
                                         {{ $data->credit_line_amount }}</td>
                                     <td style="text-align: center;text-transform: uppercase;">

                                         <!-- Button trigger modal -->
                                         <button type="button" class="btn btn-primary" data-toggle="modal"
                                             data-target="#exampleModal_location{{ $data->id }}">
                                             {{ $data->location->location }}
                                         </button>

                                         <!-- Modal -->
                                         <div class="modal fade" id="exampleModal_location{{ $data->id }}"
                                             tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                             aria-hidden="true">
                                             <div class="modal-dialog" role="document">
                                                 <div class="modal-content">
                                                     <div class="modal-header">
                                                         <h5 class="modal-title" id="exampleModalLabel">
                                                             {{ $data->store_name }}</h5>
                                                         <button type="button" class="close" data-dismiss="modal"
                                                             aria-label="Close">
                                                             <span aria-hidden="true">&times;</span>
                                                         </button>
                                                     </div>
                                                     <form action="customer_location_update" method="post">
                                                         @csrf
                                                         <div class="modal-body">
                                                             <table class="table table-bordered table-hover">
                                                                 <thead>
                                                                     <tr>
                                                                         <th>CURRENT LOCATION:</th>
                                                                         <th>{{ $data->location->location }}</th>
                                                                     </tr>
                                                                     <tr>
                                                                         <th>TRANSFER TO:</th>
                                                                         <th>
                                                                             <select class="form-control select2bs4"
                                                                                 name="location_id" id="location_id"
                                                                                 style="width:100%;" required>
                                                                                 <option value="" default>Select
                                                                                 </option>
                                                                                 @foreach ($location as $location_data)
                                                                                     <option
                                                                                         value="{{ $location_data->id }}">
                                                                                         {{ $location_data->location }}
                                                                                     </option>
                                                                                 @endforeach
                                                                             </select>
                                                                             <input type="hidden" name="customer_id"
                                                                                 value="{{ $data->id }}">
                                                                         </th>
                                                                     </tr>
                                                                 </thead>
                                                             </table>
                                                         </div>
                                                         <div class="modal-footer">
                                                             <button type="button" class="btn btn-secondary"
                                                                 data-dismiss="modal">Close</button>
                                                             <button type="submit" class="btn btn-primary">Save
                                                                 changes</button>
                                                         </div>
                                                     </form>
                                                 </div>
                                             </div>
                                         </div>
                                     </td>
                                     <td style="text-align: center;text-transform: uppercase;">
                                         {{ $data->detailed_location }}</td>
                                     <td style="text-align: center;text-transform: uppercase;">
                                         {{ $data->detailed_location }}</td>
                                     <td style="text-align: center;text-transform: uppercase;">{{ $data->contact_person }}
                                     </td>
                                     <td style="text-align: center;text-transform: uppercase;">{{ $data->contact_number }}
                                     </td>
                                     <td>
                                         <!-- Button trigger modal -->
                                         <button type="button" class="btn btn-primary btn-block" data-toggle=modal
                                             data-target="#exampleModal{{ $data->id }}">
                                             VIEW <i class="fas fa-info-circle"></i>
                                         </button>

                                         <!-- Modal -->
                                         <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1"
                                             role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                             <div class="modal-dialog" role="document">
                                                 <div class="modal-content">
                                                     <div class="modal-header">
                                                         <h5 class="modal-title" id="exampleModalLabel">ADDITION
                                                             INFORMATION</h5>
                                                         <button type="button" class="close" data-dismiss="modal"
                                                             aria-label="Close">
                                                             <span aria-hidden="true">&times;</span>
                                                         </button>
                                                     </div>
                                                     <div class="modal-body">
                                                         <table class="table table-bordered table-hover">
                                                             <thead>
                                                                 <tr>
                                                                     <th colspan="2"
                                                                         style="font-weight: bold;text-align: center;">
                                                                         PRICE LEVEL PER PRINCIPAL</th>
                                                                 </tr>
                                                                 <tr>
                                                                     <th>Principal</th>
                                                                     <th>Price Level</th>
                                                                 </tr>
                                                             </thead>
                                                             <tbody>
                                                                 @foreach ($data->customer_principal_price as $price_level)
                                                                     <tr>
                                                                         <td>{{ $price_level->principal->principal }}</td>
                                                                         <td>{{ $price_level->price_level }}</td>
                                                                     </tr>
                                                                 @endforeach
                                                             </tbody>
                                                         </table>

                                                         <table class="table table-bordered table-hover">
                                                             <thead>
                                                                 <tr>
                                                                     <th>Principal</th>
                                                                     <th>Discount Rate %</th>
                                                                 </tr>
                                                             </thead>
                                                             <tbody>
                                                                 @foreach ($data->customer_discount as $discount_rate)
                                                                     <tr>
                                                                         <td>{{ $discount_rate->principal->principal }}
                                                                         </td>
                                                                         <td style="text-align: center;">
                                                                             {{ number_format($discount_rate->customer_discount, 2, '.', ',') }}
                                                                         </td>
                                                                     </tr>
                                                                 @endforeach
                                                             </tbody>
                                                         </table>

                                                         <table class="table table-bordered table-hover">
                                                             <thead>
                                                                 <tr>
                                                                     <th colspan="3">STORE CODE PER PRINCIPAL</th>
                                                                 </tr>
                                                                 <tr>
                                                                     <th>PRINCIPAL</th>
                                                                     <th>STORE CODE</th>
                                                                 </tr>
                                                             </thead>
                                                             <tbody>
                                                                 @foreach ($data->customer_principal_code as $store_code)
                                                                     <tr>
                                                                         <td>{{ $store_code->principal->principal }}</td>
                                                                         <td>{{ $store_code->store_code }}</td>
                                                                     </tr>
                                                                 @endforeach
                                                             </tbody>
                                                         </table>
                                                     </div>
                                                     <div class="modal-footer">
                                                         {{--  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </td>
                                 </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>
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
             $('.loading').show();
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
                         $('.loading').hide();

                     } else {
                         Swal.fire(
                             'Something went wrong!',
                             'Redo process or contact system administrator',
                             'error'
                         )
                         $('.loading').hide();
                     }
                 },
             });
         }));
     </script>
     </body>

     </html>
 @endsection
