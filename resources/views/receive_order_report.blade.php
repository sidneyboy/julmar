  @extends('layouts.master')

  @section('title', 'Receive Order Report')

  @section('navbar')


  @section('sidebar')


  @section('content')
      <!-- Main content -->
      <section class="content">

          <!-- Default box -->
          <div class="card">
              <div class="card-header">
                  <h3 class="card-title" style="font-weight: bold;">RECEIVE ORDER REPORT</h3>

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
                      <div class="col-md-6" style="margin-bottom: 10px;">
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
                          <div class="form-group">
                              <select class="form-control" id="principal" style="width:100%;">
                                  <option value="" default>Select Principal</option>
                                  @foreach ($principals as $principal)
                                      <option value="{{ $principal->id . '=' . $principal->principal }}">
                                          {{ $principal->principal }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <button class="btn btn-info float-right btn-sm" id="generate">Generate Report</button>
                      </div>
                  </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <div id="show_report_list"></div>
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

          var hasSuccess = '<?php echo Session::has('success'); ?>';
          if (hasSuccess) {
              toastr.success('New Sku Information Saved!')
          }

          var deleteSuccess = '<?php echo Session::has('deleteSuccess'); ?>';
          if (deleteSuccess) {
              toastr.warning('Sku Information Deleted!')
          }

          $('#generate').on('click', function(e) {
              var date = $('#reservation').val();
              var principal = $('#principal').val();
              $('#loader').show();
              $.post({
                  type: "POST",
                  url: "/receive_order_report_list",
                  data: 'date=' + date + '&principal=' + principal,
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
