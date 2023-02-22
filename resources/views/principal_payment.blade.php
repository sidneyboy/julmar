  @extends('layouts.master')
  @section('title', 'Principal Payment')
  @section('navbar')
  @section('sidebar')
  @section('content')

      <br />
      <!-- Main content -->
      <section class="content">
          <!-- Default box -->
          <div class="card">
              <div class="card-header">
                  <h3 class="card-title" style="font-weight: bold;">PRINCIPAL PAYMENT</h3>
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
                  <form id="principal_payment_generate_final_summary">
                      @csrf
                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Select Principal</label>
                                  <select class="form-control select2bs4" required name="principal" id="principal"
                                      style="width:100%;">
                                      <option value="" default>Select Principal</option>
                                      @foreach ($principal_data as $data)
                                          <option value="{{ $data->id }}">{{ $data->principal }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Current Accounts Payable</label>
                                  <input type="text" id="current_accounts_payable" style="text-align: center;"
                                      class="form-control" disabled>
                                  <input type="hidden" id="current_accounts_payable_final"
                                      name="current_accounts_payable_final" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Amount:</label>
                                  <input type="text" name="amount" class="form-control" required
                                      onkeypress="return isNumberKey(event)">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Cheque #:</label>
                                  <input type="text" name="cheque_number" class="form-control" required>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Disbursement Voucher #:</label>
                                  <input type="text" name="disbursement_number" class="form-control" required>
                              </div>
                          </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <button type="submit" class="btn btn-info btn-sm float-right">Proceed</button>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <div id="principal_payment_generate_final_summary_page"></div>
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

          $("#principal").change(function() {
              principal = $('#principal').val();
              $.ajax({
                  url: "principal_payment_generate_accounts_payable",
                  type: "get",
                  data: 'principal=' + principal,
                  contentType: false,
                  cache: false,
                  processData: false,
                  success: function(data) {
                      $('#current_accounts_payable').val(data);
                      $('#current_accounts_payable_final').val(data);
                  },
              });
          });


          $("#principal_payment_generate_final_summary").on('submit', (function(e) {
              e.preventDefault();
              //$('.loading').show();
              $.ajax({
                  url: "principal_payment_generate_final_summary",
                  type: "POST",
                  data: new FormData(this),
                  contentType: false,
                  cache: false,
                  processData: false,
                  success: function(data) {
                      $('#principal_payment_generate_final_summary_page').html(data);
                  },
              });
          }));
      </script>
      </body>

      </html>
  @endsection
