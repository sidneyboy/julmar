 @extends('layouts.master')

 @section('navbar')


 @section('sidebar')


 @section('content')

     <!-- Main content -->
     <section class="content">

         <!-- Default box -->
         <div class="card">
             <div class="card-header">
                 <h3 class="card-title" style="font-weight: bold;">LOCATION</h3>

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
                 <form id="submit_location" method="post">
                     <div class="row">
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label>Sales Area</label>
                                 <input type="text" name="location" class="form-control"
                                     style="text-transform: uppercase" required>
                             </div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group">
                                 <input type="submit" value="SUBMIT" class="btn btn-sm float-right btn-success" />
                             </div>
                         </div>
                     </div>
                 </form>
                 <div class="row">
                     <div class="col-md-12">
                         <label for="">Sales Area List</label>
                         <table class="table table-bordered table-hover table-striped table-sm" id="example1">
                             <thead>
                                 <tr>
                                     <th>ID</th>
                                     <th>Sales Area</th>
                                     <th>Detailed Location</th>
                                     <th>Add Location</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($location as $data)
                                     <tr>
                                         <td>{{ $data->id }}</td>
                                         <td>{{ $data->location }}</td>
                                         <td><button type="button" class="btn btn-info btn-sm btn-block"
                                                 data-toggle="modal" data-target="#exampleModal{{ $data->id }}">
                                                 View
                                             </button>

                                             <!-- Modal -->
                                             <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1"
                                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                 <div class="modal-dialog " role="document">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title" id="exampleModalLabel">
                                                                 {{ $data->location }}</h5>
                                                             <button type="button" class="close" data-dismiss="modal"
                                                                 aria-label="Close">
                                                                 <span aria-hidden="true">&times;</span>
                                                             </button>
                                                         </div>
                                                         <div class="modal-body">
                                                             <table class="table table-bordered table-striped table-sm"
                                                                 style="width:100%;">
                                                                 <thead>
                                                                     <tr>
                                                                        <th>Sales Area</th>
                                                                        <th>Location</th>
                                                                     </tr>
                                                                 </thead>
                                                                 <tbody>
                                                                    @foreach ($data->location_details as $item)
                                                                        <tr>
                                                                            <td>{{ $data->location }}</td>
                                                                            <td>{{ $item->barangay }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                 </tbody>
                                                             </table>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </td>
                                         <td><button type="button" class="btn btn-info btn-sm btn-block"
                                                 data-toggle="modal" data-target="#exampleModaladd_location{{ $data->id }}">
                                                 Add
                                             </button>

                                             <!-- Modal -->
                                             <div class="modal fade" id="exampleModaladd_location{{ $data->id }}" tabindex="-1"
                                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                 <div class="modal-dialog " role="document">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title" id="exampleModalLabel">
                                                                 {{ $data->location }}</h5>
                                                             <button type="button" class="close" data-dismiss="modal"
                                                                 aria-label="Close">
                                                                 <span aria-hidden="true">&times;</span>
                                                             </button>
                                                         </div>
                                                         <form action="{{ route('location_add_details') }}" method="post">
                                                             @csrf
                                                             <div class="modal-body">
                                                                 <input type="text" name="detailed_location"
                                                                     class="form-control" required>
                                                                 <input type="hidden" name="id"
                                                                     value="{{ $data->id }}" class="form-control"
                                                                     required>
                                                             </div>
                                                             <div class="modal-footer">
                                                                 <button class="btn btn-sm float-right btn-success"
                                                                     type="submit">Save</button>
                                                             </div>
                                                         </form>
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
         $(document).ready(function() {
             var table = $('#example1').DataTable({
                 responsive: true,
                 paging: false,
                 ordering: true,
                 info: false,
                 dom: 'Bfrtip',
                 buttons: [
                     'copyHtml5',
                     'excelHtml5',
                     'csvHtml5',
                     'pdfHtml5'
                 ]
             });
             new $.fn.dataTable.FixedHeader(table);
         });

         $("#submit_location").on('submit', (function(e) {
             e.preventDefault();
             $('#loader').show();
             $.ajax({
                 url: "location_save",
                 type: "POST",
                 data: new FormData(this),
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(data) {
                     if (data == 'saved') {
                         Swal.fire({
                             position: 'top-end',
                             icon: 'success',
                             title: 'Your work has been saved',
                             showConfirmButton: false,
                             timer: 1500
                         });

                         location.reload();
                     } else {
                         $('#loader').hide();
                         Swal.fire(
                             'Cannot Proceed',
                             'Existing Location!!',
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
