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
        <span style="font-weight: bold;font-size:18px;">RETURNED DELIVERIES RECEIPT #: {{ $return_id }} ({{ $principal_name }})</span><br />
        <span style="font-size:15px;">
        </div>
      </div>
      <!-- /.row -->
      <!-- Table row -->
      <div class="row">
        <div class="col-12 table-responsive">
          <div class="table table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th style="text-align: center">Code</th>
                  <th style="text-align: center">Description</th>
                  <th style="text-align: center">UOM</th>
                  <th style="text-align: center">Quantity</th>
                  <th style="text-align: center">Invoice Cost</th>
                  <th style="text-align: center">Total Amount<br/>Vat Inc</th>
                  <th style="text-align: center">Vatable Purchase</th>
                  <th style="text-align: center">Discount</th>
                  <th style="text-align: center">Bo Allowance</th>
                  <th style="text-align: center">Vat Amount</th>
                  <th style="text-align: center">Final Total Cost</th>
                  <th style="text-align: center">Final unit Cost</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($return_details_data as $data)
                <tr>
                  <td style="text-transform: uppercase;text-align: center">{{ $data->sku->sku_code }}</td>
                  <td style="text-transform: uppercase;text-align: center">{{ $data->sku->description }}</td>
                  <td style="text-transform: uppercase;text-align: center">{{ $data->sku->unit_of_measurement }}</td>
                  <td style="text-align: center;">{{ $data->quantity_return }}</td>
                  <td style="text-align: right;">{{ number_format($data->unit_cost,2,".",",") }}</td>
                  <td style="text-align: right;">
                    @php
                    $total_amount = $data->quantity_return * $data->unit_cost;
                    $sum_total_amount[] = $total_amount;
                    @endphp
                    {{ number_format($total_amount,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                    
                    $vatable_purchase = $total_amount/1.12;
                    $sum_vatable_purchase[] = $vatable_purchase;
                    @endphp
                    {{ number_format($vatable_purchase,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                    
                    $discount = $vatable_purchase*$principal_discount->total_discount/100;
                    $sum_discount[] = $discount;
                    @endphp
                    {{ number_format($discount,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                    
                    $bo_allowance = $vatable_purchase*$principal_discount->total_bo_allowance_discount/100;
                    $sum_bo_allowance[] = $bo_allowance;
                    @endphp
                    {{ number_format($bo_allowance,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                    
                    $vat = ($vatable_purchase - $discount - $bo_allowance) *0.12;
                    $sum_vat[] = $vat;
                    @endphp
                    {{ number_format($vat,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                    
                    $final_total_cost = $vatable_purchase - $discount - $bo_allowance + $vat;
                    $sum_final_total_cost[] = $final_total_cost;
                    @endphp
                    {{ number_format($final_total_cost,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                    
                    $final_unit_cost = $final_total_cost/$data->quantity_return;
                    $sum_final_unit_cost[] = $final_unit_cost;
                    @endphp
                    
                    {{ number_format($final_unit_cost,2,".",",") }}
                  </td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="5" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
                  <td style="font-weight: bold;text-align: right;">{{ number_format(array_sum($sum_total_amount),2,".",",") }}</td>
                  <td style="font-weight: bold;text-align: right;">{{ number_format(array_sum($sum_vatable_purchase),2,".",",") }}</td>
                  <td style="font-weight: bold;text-align: right;">{{ number_format(array_sum($sum_discount),2,".",",") }}</td>
                  <td style="font-weight: bold;text-align: right;">{{ number_format(array_sum($sum_bo_allowance),2,".",",") }}</td>
                  <td style="font-weight: bold;text-align: right;">{{ number_format(array_sum($sum_vat),2,".",",") }}</td>
                  <td style="font-weight: bold;text-align: right;">{{ number_format(array_sum($sum_final_total_cost),2,".",",") }}</td>
                </tr>
              </tbody>
            </table>
            <table class="table table-bordered table-hover">
              <tr>
                <td style="font-weight: bold; text-align: left;width:50%;">SUMMARY OF DEDUCTION:</td>
                <td></td>
              </tr>
              <tr>
                <td style="font-weight: bold; text-align: left;width:50%;">VATABLE PURCHASE:</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                  
                  @php
                  $return_vatable_purchase = array_sum($sum_total_amount)/1.12;
                  @endphp
                  {{ number_format($return_vatable_purchase,2,".",",") }}
                  <input type="hidden" name="return_vatable_purchase" value="{{ $return_vatable_purchase }}">
                </td>
              </tr>
              <tr>
                <td style="text-align: left;width:50%;">LESS: DISCOUNTS</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                  @php
                  $return_less_discount = array_sum($sum_discount) + array_sum($sum_bo_allowance);
                  @endphp
                  {{  number_format($return_less_discount,2,".",",") }}
                  <input type="hidden" name="return_less_discount" value="{{ $return_less_discount }}">
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold;">NET OF DISCOUNTS</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                  @php
                  $return_net_discount = $return_vatable_purchase - $return_less_discount;
                  @endphp
                  {{ number_format($return_net_discount,2,".",",") }}
                  <input type="hidden" name="return_net_discount" value="{{ $return_net_discount }}">
                </td>
              </tr>
              <tr>
                <td>VAT AMOUNT</td>
                <td style="text-align: right;font-size: 15px;">
                  @php
                  $return_vat_amount = $return_net_discount*.12;
                  @endphp
                  {{ number_format($return_vat_amount,2,".",",") }}
                  <input type="hidden" name="return_vat_amount" value="{{ $return_vat_amount }}">
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold;">NET DEDUCTION</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                  
                  @php
                  $return_net_of_deduction = $return_net_discount + $return_vat_amount;
                  @endphp
                  {{ number_format($return_net_of_deduction,2,".",",") }}
                  <input type="hidden" name="return_net_of_deduction" value="{{ $return_net_of_deduction }}">
                </td>
              </tr>
            </table>
            <table class="table table-bordered table-hovered">
              <thead>
                <tr>
                  <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                  <th style="text-align: center;">DR</th>
                  <th style="text-align: center;">CR</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align: center;">ACCOUNTS PAYABLE - {{ $principal_name }}</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;">{{ number_format($return_net_of_deduction,2,".",",") }}</td>
                  <td><input type="hidden" value="{{ $return_net_of_deduction }}" name="total_amount_return"></td>
                </tr>
                <tr>
                  <td></td>
                  <td style="text-align: center;">INVENTORY - {{ $principal_name }}</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;">{{ number_format($return_net_of_deduction,2,".",",") }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <br /><br />
      
      <div class="row invoice-info" style="width:100%;text-align: center;">
        <div class="col-sm-6 invoice-col">
          <span style="text-align: center;">
            Purchased By: <br />
            <u style="font-weight: bold;"></u>
          </span>
        </div>
        <div class="col-sm-6 invoice-col">
          <span style="text-align: center;">
            Prepared By:<br />
            <u style="font-weight: bold;"> {{ $prepared_by->name }}</u>
          </span>
        </div>
      </div>
      <div class="row invoice-info" style="width:100%;text-align: center;">
        <div class="col-sm-12 invoice-col">
          <span style="text-align: center;">
            Date: <br />
            <u style="font-weight: bold;">
            {{ $date }}
            </u>
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