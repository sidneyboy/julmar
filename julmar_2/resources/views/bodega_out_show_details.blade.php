  <link rel="stylesheet" href="{{ asset('/adminLte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/adminLte/dist/css/adminlte.min.css') }}">
  <style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin: 10;  /* this affects the margin in the printer settings */
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
            <img src="{{ asset('/adminLte/julmar.png') }}" style="width:50px;" alt=""> JULMAR COMMERCIAL. INC,
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
        <span style="font-weight: bold;font-size:18px;text-transform: uppercase;">BODEGA OUT {{ $remarks }} #: {{ $id }} ({{ $principal_name }}) </span><br />
        <span style="font-size:15px;">
      </div>
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
@if($remarks == 'Case to Butal')
        <div class="container-fluid">
          <label>OUT FROM CASE</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center">CODE</th>
                <th style="text-align: center">DESCRIPTION</th>
                <th style="text-align: center">QUANTITY</th>
                <th style="text-align: center">UNIT OF MEASUREMENT</th>
              </tr>
            </thead>
            <tbody>
              
              <tr>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->sku->sku_code }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->sku->description }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->quantity }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->sku->unit_of_measurement }}</td>
              </tr>
              
            </tbody>
          </table>
          <label>IN TO BUTAL</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center">CODE</th>
                <th style="text-align: center">DESCRIPTION</th>
                <th style="text-align: center">QUANTITY</th>
                <th style="text-align: center">UNIT OF MEASUREMENT</th>
              </tr>
            </thead>
            <tbody>
              
              <tr>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->equivalent_sku->sku_code }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->equivalent_sku->description }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->transfer_quantity }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->equivalent_sku->unit_of_measurement }}</td>
              </tr>
              
            </tbody>
          </table>
          <label>COMPUTER FOR FINAL UNIT COST</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center">QTY CASE</th>
                <th style="text-align: center">FUC</th>
                <th style="text-align: center">FTC</th>
                <th style="text-align: center">QTY BUTAL</th>
                <th style="text-align: center">FUC</th>
                <th style="text-align: center">FTC</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-align: center;">{{ $bodega_out_details->quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $final_unit_cost_case = $final_unit_cost;
                  @endphp
                  {{ number_format($final_unit_cost_case,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $final_total_cost_case = $final_unit_cost*$bodega_out_details->quantity;
                  @endphp
                  {{ number_format($final_total_cost_case,2,".",",") }}
                </td>
                <td style="text-align: center;">
                  {{ $bodega_out_details->transfer_quantity }}
                </td>
                <td style="text-align: right;">
                  @php
                  $final_unit_cost_butal = $final_total_cost_case/$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($final_unit_cost_butal,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $final_total_cost_butal = $final_unit_cost_butal*$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($final_total_cost_butal,2,".",",") }}
                </td>
              </tr>
            </tbody>
          </table>
          <label><u>COMPUTE FOR PRICE ONE</u></label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center;" colspan="3">CASE</th>
                <th style="text-align: center;" colspan="3">BUTAL</th>
              </tr>
              <tr>
                <th style="text-align: center;">QTY CASE</th>
                <th style="text-align: center;">P1</th>
                <th style="text-align: center;">TOTAL P1</th>
                <th style="text-align: center;">QTY BUTAL</th>
                <th style="text-align: center;">P1</th>
                <th style="text-align: center;">TOTAL P1</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-align: center;">{{ $bodega_out_details->quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $price_1_case = $price_1;
                  @endphp
                  {{ number_format($price_1_case,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $price_1_total_cost_case = $price_1_case*$bodega_out_details->quantity;
                  @endphp
                  {{ number_format($price_1_total_cost_case,2,".",",") }}
                </td>
                <td style="text-align: center;">{{ $bodega_out_details->transfer_quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $price_1_butal = $price_1_total_cost_case/$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($price_1_butal,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $price_1_total_cost_butal = $price_1_butal*$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($price_1_total_cost_butal,2,".",",") }}
                </td>
              </tr>
            </tbody>
          </table>
          
          <label><u>COMPUTE FOR PRICE TWO</u></label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center;" colspan="3">CASE</th>
                <th style="text-align: center;" colspan="3">BUTAL</th>
              </tr>
              <tr>
                <th style="text-align: center;">QTY CASE</th>
                <th style="text-align: center;">P2</th>
                <th style="text-align: center;">TOTAL P2</th>
                <th style="text-align: center;">QTY BUTAL</th>
                <th style="text-align: center;">P2</th>
                <th style="text-align: center;">TOTAL P2</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-align: center;">{{ $bodega_out_details->quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $price_2_case = $price_2;
                  @endphp
                  {{ number_format($price_2_case,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $price_2_total_cost_case = $price_2_case*$bodega_out_details->quantity;
                  @endphp
                  {{ number_format($price_2_total_cost_case,2,".",",") }}
                </td>
                <td style="text-align: center;">{{ $bodega_out_details->transfer_quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $price_2_butal = $price_2_total_cost_case/$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($price_2_butal,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $price_2_total_cost_butal = $price_2_butal*$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($price_2_total_cost_butal,2,".",",") }}
                </td>
              </tr>
            </tbody>
          </table>
          <label><u>COMPUTE FOR PRICE THREE</u></label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center;" colspan="3">CASE</th>
                <th style="text-align: center;" colspan="3">BUTAL</th>
              </tr>
              <tr>
                <th style="text-align: center;">QTY CASE</th>
                <th style="text-align: center;">P3</th>
                <th style="text-align: center;">TOTAL P3</th>
                <th style="text-align: center;">QTY BUTAL</th>
                <th style="text-align: center;">P3</th>
                <th style="text-align: center;">TOTAL P3</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-align: center;">{{ $bodega_out_details->quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $price_3_case = $price_3;
                  @endphp
                  {{ number_format($price_3_case,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $price_3_total_cost_case = $price_3_case*$bodega_out_details->quantity;
                  @endphp
                  {{ number_format($price_3_total_cost_case,2,".",",") }}
                </td>
                <td style="text-align: center;">{{ $bodega_out_details->transfer_quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $price_3_butal = $price_3_total_cost_case/$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($price_3_butal,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $price_3_total_cost_butal = $price_3_butal*$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($price_3_total_cost_butal,2,".",",") }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
@else
        <div class="container-fluid">
          <label>OUT FROM BUTAL</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center">CODE</th>
                <th style="text-align: center">DESCRIPTION</th>
                <th style="text-align: center">QUANTITY</th>
                <th style="text-align: center">UNIT OF MEASUREMENT</th>
              </tr>
            </thead>
            <tbody>
              
              <tr>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->sku->sku_code }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->sku->description }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->quantity }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->sku->unit_of_measurement }}</td>
              </tr>
              
            </tbody>
          </table>
          <label>IN TO CASE</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center">CODE</th>
                <th style="text-align: center">DESCRIPTION</th>
                <th style="text-align: center">QUANTITY</th>
                <th style="text-align: center">UNIT OF MEASUREMENT</th>
              </tr>
            </thead>
            <tbody>
              
              <tr>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->equivalent_sku->sku_code }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->equivalent_sku->description }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->transfer_quantity }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $bodega_out_details->equivalent_sku->unit_of_measurement }}</td>
              </tr>
              
            </tbody>
          </table>
          <label>COMPUTER FOR FINAL UNIT COST</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center">QTY BUTAL</th>
                <th style="text-align: center">FUC</th>
                <th style="text-align: center">FTC</th>
                <th style="text-align: center">QTY CASE</th>
                <th style="text-align: center">FUC</th>
                <th style="text-align: center">FTC</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-align: center;">{{ $bodega_out_details->quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $final_unit_cost_case = $final_unit_cost;
                  @endphp
                  {{ number_format($final_unit_cost_case,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $final_total_cost_case = $final_unit_cost*$bodega_out_details->quantity;
                  @endphp
                  {{ number_format($final_total_cost_case,2,".",",") }}
                </td>
                <td style="text-align: center;">
                  {{ $bodega_out_details->transfer_quantity }}
                </td>
                <td style="text-align: right;">
                  @php
                  $final_unit_cost_butal = $final_total_cost_case/$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($final_unit_cost_butal,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $final_total_cost_butal = $final_unit_cost_butal*$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($final_total_cost_butal,2,".",",") }}
                </td>
              </tr>
            </tbody>
          </table>
          <label><u>COMPUTE FOR PRICE ONE</u></label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center;" colspan="3">BUTAL</th>
                <th style="text-align: center;" colspan="3">CASE</th>
              </tr>
              <tr>
                <th style="text-align: center;">QTY BUTAL</th>
                <th style="text-align: center;">P1</th>
                <th style="text-align: center;">TOTAL P1</th>
                <th style="text-align: center;">QTY CASE</th>
                <th style="text-align: center;">P1</th>
                <th style="text-align: center;">TOTAL P1</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-align: center;">{{ $bodega_out_details->quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $price_1_case = $price_1;
                  @endphp
                  {{ number_format($price_1_case,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $price_1_total_cost_case = $price_1_case*$bodega_out_details->quantity;
                  @endphp
                  {{ number_format($price_1_total_cost_case,2,".",",") }}
                </td>
                <td style="text-align: center;">{{ $bodega_out_details->transfer_quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $price_1_butal = $price_1_total_cost_case/$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($price_1_butal,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $price_1_total_cost_butal = $price_1_butal*$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($price_1_total_cost_butal,2,".",",") }}
                </td>
              </tr>
            </tbody>
          </table>
          
          <label><u>COMPUTE FOR PRICE TWO</u></label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center;" colspan="3">BUTAL</th>
                <th style="text-align: center;" colspan="3">CASE</th>
              </tr>
              <tr>
                <th style="text-align: center;">QTY BUTAL</th>
                <th style="text-align: center;">P2</th>
                <th style="text-align: center;">TOTAL P2</th>
                <th style="text-align: center;">QTY CASE</th>
                <th style="text-align: center;">P2</th>
                <th style="text-align: center;">TOTAL P2</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-align: center;">{{ $bodega_out_details->quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $price_2_case = $price_2;
                  @endphp
                  {{ number_format($price_2_case,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $price_2_total_cost_case = $price_2_case*$bodega_out_details->quantity;
                  @endphp
                  {{ number_format($price_2_total_cost_case,2,".",",") }}
                </td>
                <td style="text-align: center;">{{ $bodega_out_details->transfer_quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $price_2_butal = $price_2_total_cost_case/$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($price_2_butal,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $price_2_total_cost_butal = $price_2_butal*$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($price_2_total_cost_butal,2,".",",") }}
                </td>
              </tr>
            </tbody>
          </table>
          <label><u>COMPUTE FOR PRICE THREE</u></label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center;" colspan="3">BUTAL</th>
                <th style="text-align: center;" colspan="3">CASE</th>
              </tr>
              <tr>
                <th style="text-align: center;">QTY BUTAL</th>
                <th style="text-align: center;">P3</th>
                <th style="text-align: center;">TOTAL P3</th>
                <th style="text-align: center;">QTY CASE</th>
                <th style="text-align: center;">P3</th>
                <th style="text-align: center;">TOTAL P3</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-align: center;">{{ $bodega_out_details->quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $price_3_case = $price_3;
                  @endphp
                  {{ number_format($price_3_case,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $price_3_total_cost_case = $price_3_case*$bodega_out_details->quantity;
                  @endphp
                  {{ number_format($price_3_total_cost_case,2,".",",") }}
                </td>
                <td style="text-align: center;">{{ $bodega_out_details->transfer_quantity }}</td>
                <td style="text-align: right;">
                  @php
                  $price_3_butal = $price_3_total_cost_case/$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($price_3_butal,2,".",",") }}
                </td>
                <td style="text-align: right;">
                  @php
                  $price_3_total_cost_butal = $price_3_butal*$bodega_out_details->transfer_quantity;
                  @endphp
                  {{ number_format($price_3_total_cost_butal,2,".",",") }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
@endif

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