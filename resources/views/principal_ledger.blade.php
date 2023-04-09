  @extends('layouts.master')
  @section('title', 'Principal Ledger')
  @section('navbar')
  @section('sidebar')
  @section('content')

      <br />
      <!-- Main content -->
      <section class="content">
          <!-- Default box -->
          <div class="card">
              <div class="card-header">
                  <h3 class="card-title" style="font-weight: bold;">PRINCIPAL LEDGER</h3>
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
                  <form id="principal_ledger_generate_report">
                      @csrf
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Select Ledger Date Range</label>
                                  <div class="input-group">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text">
                                              <i class="far fa-calendar-alt"></i>
                                          </span>
                                      </div>
                                      <input type="text" name="date_range" required class="form-control float-right"
                                          id="reservation">
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Select Principal</label>
                                  <select class="form-control select2bs4" required name="principal" style="width:100%;">
                                      <option value="" default>Select</option>
                                      {{-- <option value="all">All</option> --}}
                                      @foreach ($principal as $data)
                                          <option value="{{ $data->id }}">{{ $data->principal }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <button type="submit" class="btn btn-info btn-sm float-right">Generate Ledger</button>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <div id="principal_ledger_generate_report_proceed"></div>
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


          $("#principal_ledger_generate_report").on('submit', (function(e) {
              e.preventDefault();
              $('#loader').show();
              $.ajax({
                  url: "principal_ledger_generate_report",
                  type: "POST",
                  data: new FormData(this),
                  contentType: false,
                  cache: false,
                  processData: false,
                  success: function(data) {
                      if (data == 'no_data') {
                          $('#loader').hide();
                          Swal.fire({
                              position: 'top-end',
                              icon: 'error',
                              title: 'No data found!',
                              showConfirmButton: false,
                              timer: 1500
                          })
                      } else {
                          $('#loader').hide();
                          $('#principal_ledger_generate_report_proceed').html(data);
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
