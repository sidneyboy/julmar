  <link rel="stylesheet" href="{{ asset('/adminLte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/adminLte/dist/css/adminlte.min.css') }}">
  <style type="text/css" media="print">
      @page {
          size: auto;
          /* auto is the initial value */
          margin: 10;
          /* this affects the margin in the printer settings */
      }
  </style>
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
          <!-- title row -->
          <div class="row">
              <div class="col-12">
                  <center>
                      <h2 class="page-header">
                          JULMAR COMMERCIAL. INC,
                      </h2>
                  </center>
              </div>
              <!-- /.col -->
          </div><br />
          <!-- info row -->
          <div class="row invoice-info">
              <div class="col-sm-12 invoice-col">
                  <center>
                      <h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
                      <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
                  </center>
                  <br />
                  <center>
                      <span style="font-weight: bold;font-size:18px;text-transform: uppercase;">TRANSFER TO BRANCH #:
                          {{ $id }} ({{ $principal_name }}) </span><br />

                      <br />
                      @php
                          $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                      @endphp


                      <center>
                          {!! $generator->getBarcode($id, $generator::TYPE_CODE_128) !!}
                          <p>{{ $id }}</p>
                      </center>

              </div>
          </div>
          <!-- /.row -->
          <br />
          <!-- Table row -->
          <div class="container">
              <table class="table table-bordered table-hover table-striped table-sm">
                  <thead>
                      <tr>
                          <th style="text-transform: uppercase;text-align: center">Code</th>
                          <th style="text-transform: uppercase;text-align: center">Description</th>
                          <th style="text-transform: uppercase;text-align: center">Quantity</th>
                          <th style="text-transform: uppercase;text-align: center">Final Unit Cost</th>
                          <th style="text-transform: uppercase;text-align: center">Total Amount</th>


                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($transfer_to_bran_details as $data)
                          <tr>
                              <td style="text-transform: uppercase;text-align: center">{{ $data->sku->sku_code }}</td>
                              <td style="text-transform: uppercase;text-align: center">{{ $data->sku->description }}
                              </td>
                              <td style="text-transform: uppercase;text-align: center">{{ $data->quantity }}</td>
                              <td style="text-transform: uppercase;text-align: center">
                                  {{ number_format($data->final_unit_cost, 2, '.', ',') }}</td>
                              <th style="text-transform: uppercase;text-align: center">
                                  @php
                                      $sum_total_amount[] = $data->final_unit_cost * $data->quantity;
                                      $total_amount = $data->final_unit_cost * $data->quantity;
                                  @endphp

                                  {{ number_format($total_amount, 2, '.', ',') }}
                              </th>

                          </tr>
                      @endforeach
                      <tr>
                          <td colspan="4" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
                          <td style="text-align: center;font-weight: bold;">
                              {{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}</td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <!-- /.row -->
          <br /><br />



          <div class="row invoice-info" style="width:100%;text-align: center;">
              <div class="col-sm-6 invoice-col">
                  <span style="">
                      Prepared By: <br /><br /><br />
                      <u style="font-weight: bold;text-transform: uppercase;">{{ $prepared_by->name }}</u>
                  </span>
              </div>
              <div class="col-sm-6 invoice-col">
                  <span style="">
                      Approved By: <br /><br /><br />
                      <u style="font-weight: bold;">JEFFERSON T. LIMCHU</u><br />
                      <p>Group Manager</p>
                  </span>
              </div>
          </div>

          <!-- /.row -->
      </section>
      <!-- /.content -->
  </div>

  <script type="text/javascript">
      //window.addEventListener("load", window.print());
  </script>
