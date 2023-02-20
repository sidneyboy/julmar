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


  <body onload="myFunction()">
      <div class="wrapper">
          <!-- Main content -->
          <section class="invoice">
              <!-- title row -->
              <br />
              <div class="row">
                  <div class="col-12">
                      <center>
                          <h2 class="page-header">
                              JULMAR COMMERCIAL. INC,
                          </h2>
                          <h5>
                              St Ignatius St., Brgy. Kauswagan<br />
                              Cagayan de Oro City, Misamis Oriental<br>
                              TELEPHONE NO: 881-9973 / 09177058232<br>
                          </h5>
                          <br>
                          <h4 style="text-align: center;font-weight: bold;">PURCHASE ORDER </h4>
                      </center>
                  </div>
                  <!-- /.col -->
              </div><br />
              <!-- info row -->
              <div class="row invoice-info" style="width:70%;margin-left: 20%;margin-right: 20%;">

                  <!-- /.col -->
                  <div class="col-sm-6 invoice-col">
                      <table>
                          <tr>
                              <td style="font-weight: bold;text-align:right">Principal <span
                                      class="float-right">:</span></td>
                              <td> {{ $principal_name }}</td>
                          </tr>
                          <tr>
                              <td style="font-weight: bold;text-align:right">Phone # <span class="float-right">:</span>
                              </td>
                              <td> {{ $principal_contact_number }}</td>
                          </tr>
                          <tr>
                              <td style="font-weight: bold;text-align:right">SO # <span class="float-right">:</span>
                              </td>
                              <td> {{ $sales_order_number }}</td>
                          </tr>
                      </table>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6 invoice-col">
                      <table>
                          <tr>
                              <td style="font-weight: bold;text-align:right">PO No. <span class="float-right">:</span>
                              </td>
                              <td> {{ $purchase_id }}</td>
                          </tr>
                          <tr>
                              <td style="font-weight: bold;text-align:right">PO Date. <span class="float-right">:</span>
                              </td>
                              <td> {{ $date }}</td>
                          </tr>
                          <tr>
                              <td style="font-weight: bold;text-align:right">Payment Due <span
                                      class="float-right">:</span></td>
                              <td> {{ $payment_term }}</td>
                          </tr>
                          <tr>
                              <td style="font-weight: bold;text-align:right">Delivery Term <span
                                      class="float-right">:</span></td>
                              <td>
                                  {{ $delivery_term }}
                              </td>
                          </tr>
                      </table>
                  </div>
                  <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row --><br />
              <div class="row">
                  <div class="container" id="hide_table">
                      <table class="table table-bordered table-sm table-hover" style="width:100%;">
                          <thead>
                              <tr>
                                  <th style="text-align: center;">SKU Code</th>
                                  <th style="text-align: center;">Description</th>
                                  <th style="text-align: center;">UOM</th>
                                  <th style="text-align: center;">Quantity</th>
                                  <th style="text-align: center;">Received</th>
                                  <th style="text-align: center;">BAL</th>
                                  <th style="text-align: center">Final Unit Cost</th>
                                  <th style="text-align: center">Total Amount</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($purchase_order_details_data as $data)
                                  <tr>

                                      <td style="text-align: left;">{{ $data->sku->sku_code }}</td>
                                      <td style="text-align: left;">{{ $data->sku->description }}</td>
                                      <td style="text-align: left;">{{ $data->sku->unit_of_measurement }}</td>
                                      <td style="text-align: right;">{{ $data->quantity }}</td>
                                      <td style="text-align: right;">
                                          @php
                                              $sum_receive[] = $data->receive;
                                          @endphp
                                          {{ $data->receive }}
                                      </td>
                                      <td style="text-align: right;">
                                          @php
                                              $sum_balance[] = $data->quantity - $data->receive;
                                          @endphp
                                          {{ $data->quantity - $data->receive }}
                                      </td>
                                      <td style="text-align: right;">{{ number_format($data->unit_cost, 2, '.', ',') }}
                                      </td>
                                      <td style="text-align: right;">
                                          @php
                                              $sum_gross[] = $data->unit_cost * $data->quantity;
                                          @endphp
                                          {{ number_format($data->unit_cost * $data->quantity, 2, '.', ',') }}
                                      </td>

                                  </tr>
                              @endforeach
                              <tr>
                                  <td colspan="3" style="font-weight: bold;text-align: center;">TOTAL</td>
                                  <td style="font-weight: bold;text-align: right;">{{ $quantity_array }}</td>
                                  <td style="text-align: right;font-weight: bold">{{ array_sum($sum_receive) }}</td>
                                  <td style="text-align: right;font-weight: bold">{{ array_sum($sum_balance) }}</td>
                                  <td></td>
                                  <td style="text-align: right;font-weight: bold">
                                      {{ number_format(array_sum($sum_gross), 2, '.', ',') }}</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>

                  <div id="print" class="container" style="display: none;">
                      <table class="table table-bordered table-sm table-hover" style="width:100%;">
                          <thead>
                              <tr>
                                  <th style="text-align: center;">SKU Code</th>
                                  <th style="text-align: center;">Description</th>
                                  <th style="text-align: center;">UOM</th>
                                  <th style="text-align: center;">Quantity</th>
                                  <th style="text-align: center">Final Unit Cost</th>
                                  <th style="text-align: center">Total Amount</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($purchase_order_details_data as $data)
                                  <tr>

                                      <td style="text-align: left;">{{ $data->sku->sku_code }}</td>
                                      <td style="text-align: left;">{{ $data->sku->description }}</td>
                                      <td style="text-align: left;">{{ $data->sku->unit_of_measurement }}</td>
                                      <td style="text-align: right;">{{ $data->quantity }}</td>

                                      <td style="text-align: right;">{{ number_format($data->unit_cost, 2, '.', ',') }}
                                      </td>
                                      <td style="text-align: right;">
                                          @php
                                              $sum_total_cost[] = $data->unit_cost * $data->quantity;
                                          @endphp
                                          {{ number_format($data->unit_cost * $data->quantity, 2, '.', ',') }}
                                      </td>

                                  </tr>
                              @endforeach
                              <tr>
                                  <td colspan="3" style="font-weight: bold;text-align: center;">TOTAL</td>
                                  <td style="font-weight: bold;text-align: right;">{{ $quantity_array }}</td>

                                  <td colspan="1"></td>
                                  <td style="text-align: right;font-weight: bold">
                                      {{ number_format(array_sum($sum_total_cost), 2, '.', ',') }}</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                  <!-- /.col -->
              </div>
              <!-- /.row -->
              <br /><br />

              <div class="row invoice-info" style="width:100%;text-align: center;">
                  <div class="col-sm-4 invoice-col">
                      <span style="">
                          Prepared By: <br /><br /><br />
                          <u style="font-weight: bold;">{{ $prepared_by }}</u>
                      </span>
                  </div>
                  <div class="col-sm-4 invoice-col">
                      <span style="">
                          Noted By: <br /><br /><br />
                          <u style="font-weight: bold;">AGUSTIN R. HERRERA</u>
                          <p>Operations Manager North - Min</p>
                      </span>
                  </div>
                  <div class="col-sm-4 invoice-col">
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
  </body>
  <script src="{{ asset('adminLte/plugins/jquery/jquery.min.js') }}"></script>
  <script type="text/javascript">
      function myFunction() {
          window.print();
      }
  </script>
