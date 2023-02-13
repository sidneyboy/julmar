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
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12 invoice-col">
        <center>
        <h5>St Ignatius St., Brgy. Kauswagan <br /> Cagayan de Oro City, Misamis Oriental</h5>
        <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
        </center>
        <center>
        <span style="font-weight: bold;font-size:18px;">RECEIVING REPORT: </span><br />
        <span style="font-size:15px;">
        </div>
      </div>
      <!-- /.row -->
      
      <div class="row invoice-info" style="width:80%;margin-left:25%;margin-right:25%;">
        <div class="col-sm-6 invoice-col">
          <table>
            <tr>
              <td style="font-weight: bold;">RR No. <span class="float-right">:</span></td>
              <td> {{ $id }}</td>
            </tr>
            <tr>
              <td style="font-weight: bold;">RR Date. <span class="float-right">:</span></td>
              <td> {{ $date }}</td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Po No. <span class="float-right">:</span></td>
              <td> {{ $received_data->purchase_order->purchase_id }}</td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Po Date <span class="float-right">:</span></td>
              <td>
                {{  $received_data->purchase_order->date }}
              </td>
            </tr>
          </table>
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
        <div class="col-sm-6 invoice-col">
          <table>
            <tr>
              <td style="font-weight: bold;">Principal <span class="float-right">:</span></td>
              <td> {{ $principal_name }}</td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Principal Invoice No. <span class="float-right">:</span></td>
              <td style="text-transform: uppercase;"> {{ $received_data->dr_si }}</td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Invoice Date <span class="float-right">:</span></td>
              <td> {{ $received_data->invoice_date }}</td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Delivery Status. <span class="float-right">:</span></td>
              <td>
                @if ($received_data->purchase_order->remarks == 'Received')
                {{ 'COMPLETE' }}
                @else
                {{ 'PARTIAL' }}
                @endif
              </td>
            </tr>
          </table>
        </div>
        <!-- /.col -->
      </div><br />
      
      <!-- Table row -->
      <div class="row">
        <div class="col-12 table-responsive">
        @if($principal_name == 'CIFPI')
          <table class="table table-hover table-bordered" style="font-size:12px;">
            <thead>
              <tr>
                <th style="text-align: center;">Code</th>
                <th style="text-align: center;">DESC</th>
                <th style="text-align: center;width:40px;">QTY</th>
                <th style="text-align: center;">UOM</th>
                <th style="text-align: center;">U/C</th>
                <th style="text-align: center;">TOTAL<br />AMOUNT<br />VAT<br />EXCLUSIVE</th>
                @foreach($principal_discount_details as $data)
                <th style="text-align: center;">{{ ucfirst($data->discount_name) }}<br />{{ $data->discount_rate }} %</th>
                @endforeach
                <th style="text-align: center;">BO ALLOWANCE {{ $principal_discount->total_bo_allowance_discount }} %</th>
                <th style="text-align: center;">VAT</th>
                <th style="text-align: center"><i>VAT INCLUSIVE</i><br/>TOTAL COST</th>
                <th style="text-align: center;width:40px;">FRT</th>
                <th style="text-align: center;">FTC</th>
                <th style="text-align: center;">FUC</th>
                <th style="text-align: center;">RMRKS</th>
                <th style="text-align: center;">EXP DATE</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($received_details as $data)
                <tr>
                  <td style="text-align: center;">{{ $data->sku->sku_code }}</td>
                  <td style="text-align: center;">{{ $data->sku->description }}</td>
                  <td style="text-align: center;">{{ $data->quantity_per_sku }}</td>
                  <td style="text-align: center;">{{ $data->sku->unit_of_measurement }}</td>
                  <td style="text-align: right;">{{ number_format($data->unit_cost_per_sku,2,".",",")  }}</td>
                  <td style="text-align: right;">
                    @php
                    $total_amount_per_sku = $data->quantity_per_sku* $data->unit_cost_per_sku;
                    $sum_total_amount_per_sku[] = $total_amount_per_sku;
                    @endphp
                    {{ number_format($total_amount_per_sku,2,".",",") }}
                  </td>
                  @php
                  $total = $total_amount_per_sku;
                  $discount_value_holder = $total;
                  $discount_value_holder_history = [];
                  $discount_value_holder_history_for_bo_allowance = [];
                  $totalArray = [];
                  $percent = [];
                  foreach($principal_discount_details as $data_discount) {
                  
                  $discount_value_holder_dummy = $discount_value_holder;
                  $less_percentage_by = ($data_discount->discount_rate / 100);
                  
                  // $discount_value_holder = $discount_value_holder_dummy - ($discount_value_holder_dummy * $less_percentage_by);
                  $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                  $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                  
                  $discount_value_holder_history[] = $discount_rate_answer;
                  $discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                  echo '<td style="text-align:right;">'. number_format($discount_rate_answer,2,".",",") .'</td>';
                  }
                  @endphp
                  <td style="text-align: right;">
                    @php
                    $bo_allowance = end($discount_value_holder_history_for_bo_allowance) -  end($discount_value_holder_history_for_bo_allowance) * ($principal_discount->total_bo_allowance_discount/100);
                    $bo_allowance_per_sku = end($discount_value_holder_history_for_bo_allowance) - $bo_allowance;
                    $sum_bo_allowance_per_sku[] = $bo_allowance_per_sku;
                    @endphp
                    {{ number_format($bo_allowance_per_sku,2,".",",") }}
                  </td>
                  <td style="text-align: right;">
                    @php
                    $vat =  ($total_amount_per_sku - (array_sum($discount_value_holder_history) + $bo_allowance_per_sku)) * 0.12;
                    $sum_vat_per_sku[] = $vat;
                    @endphp
                    {{ number_format($vat,2,".",",") }}
                  </td>
                  <td style="text-align: right;">
                    @php
                    $vat_inclusive_total_cost_per_sku = $bo_allowance*1.12;
                    $sum_vat_inclusive_total_cost_per_sku[] = $vat_inclusive_total_cost_per_sku;
                    @endphp
                    {{ number_format($vat_inclusive_total_cost_per_sku,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                    $freight_per_sku = $data->freight_per_sku * $data->quantity_per_sku;
                    $sum_freight_per_sku[] = $freight_per_sku;
                    @endphp
                    {{  number_format($freight_per_sku,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                    $final_total_cost_per_sku = $vat_inclusive_total_cost_per_sku + $freight_per_sku;
                    $sum_final_total_cost_per_sku[] = $final_total_cost_per_sku;
                    @endphp
                    {{  number_format($final_total_cost_per_sku,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                    $final_unit_cost_per_sku = $final_total_cost_per_sku / $data->quantity_per_sku;
                    @endphp
                    {{  number_format($final_unit_cost_per_sku,2,".",",") }}
                  </td>
                  <td style="text-align:center">{{ $data->remarks }}</td>
                  <td style="text-align: right">{{ $data->expiration_date }}</td>
                </tr>
              @endforeach
                <tr>
                  <td colspan="5" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                  <td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_total_amount_per_sku),2,".",",") }}
                   
                  </td>
                  @php
                  $total = array_sum($sum_total_amount_per_sku);
                  
                  $discount_value_holder = $total;
                  $discount_value_holder_history = [];
                  
                  $totalArray = [];
                  $percent = [];
                  foreach($principal_discount_details as $data_discount) {
                  
                  $discount_value_holder_dummy = $discount_value_holder;
                  $less_percentage_by = ($data_discount->discount_rate / 100);
                  
                  // $discount_value_holder = $discount_value_holder_dummy - ($discount_value_holder_dummy * $less_percentage_by);
                  $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                  $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                  
                  $discount_value_holder_history[] = $discount_rate_answer;
                  echo '<td style="text-align:right;">'. number_format($discount_rate_answer,2,".",",") .'</td>';
                 
                  }
                  @endphp
                  <td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_bo_allowance_per_sku),2,".",",") }}</td>
                  <td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_vat_per_sku),2,".",",") }}</td>
                  <td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_vat_inclusive_total_cost_per_sku),2,".",",") }}</td>
                  <td style="text-align: right;font-weight: bold">
                    {{ number_format(array_sum($sum_freight_per_sku),2,".",",") }}</td>
                  <td style="text-align: right;font-weight: bold">
                    {{ number_format(array_sum($sum_final_total_cost_per_sku),2,".",",") }}</td>
                </tr>
            </tbody>
          </table>
        @elseif($principal_name == 'PPMC')
          <table class="table table-bordered table-hover" style="font-size: 12px;">
            <thead>
              <tr>
                <th style="text-align: center;">CODE</th>
                <th style="text-align: center;">DESC</th>
                <th style="text-align: center;">QTY<br />RCVD</th>
                <th style="text-align: center;">UOM</th>
                <th style="text-align: center;">U/C</th>
                <th style="text-align: center;">TOTAL AMNT <br /><i>Vat Inclusive</i></th>
                @foreach($principal_discount_details as $data)
                <th style="text-align: center;">{{ ucfirst($data->discount_name) }}<br /> {{ $data->discount_rate }} %</th>
                @endforeach
                <th style="text-align: center;">BO<br />ALLOW<br />{{ $principal_discount->total_bo_allowance_discount }} %</th>
                <th style="text-align: center;">TOTAL DISCOUNT<br />(VAT INC)</th>
                <th style="text-align: center;">FTC</th>
                <th style="text-align: center;">FUC</th>
                <th style="text-align: center;">RMRKS</th>
                <th style="text-align: center;">EXP DATE</th>
              </tr>
            </thead>
            <tbody>
               @foreach($received_details as $data)
                <tr>
                  <td>{{ $data->sku->sku_code }}</td>
                  <td>{{ $data->sku->description }}</td>
                  <td>{{ $data->quantity_per_sku }}</td>
                  <td>{{ $data->sku->unit_of_measurement }}</td>
                  <td style="text-align: right;">{{ number_format($data->unit_cost_per_sku,2,".",",")  }}</td>
                  <td style="text-align: right">
                    @php
                    $total_amount = $data->quantity_per_sku * $data->unit_cost_per_sku;
                    $sum_total_amount[] = $total_amount;
                    @endphp
                    {{  number_format($total_amount,2,".",",") }}
                  </td>
                  @php
                  $total = $total_amount;
                  $discount_value_holder = $total;
                  $discount_value_holder_history = [];
                  $discount_value_holder_history_for_bo_allowance = [];
                  $totalArray = [];
                  $percent = [];
                  foreach($principal_discount_details as $data_discount) {

                  $discount_value_holder_dummy = $discount_value_holder;
                  $less_percentage_by = ($data_discount->discount_rate / 100);

                  // $discount_value_holder = $discount_value_holder_dummy - ($discount_value_holder_dummy * $less_percentage_by);
                  $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                  $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;

                  $discount_value_holder_history[] = $discount_rate_answer;
                  $discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                  echo '<td style="text-align:right;">'. number_format($discount_rate_answer,2,".",",") .'</td>';
                  }
                  @endphp
                  <td style="text-align: right">
                    @php
                    $bo_allowance = $total_amount * $principal_discount->total_bo_allowance_discount/100;
                    $sum_bo_allowance[] = $bo_allowance;
                    @endphp
                    {{  number_format($bo_allowance,2,".",",") }} 
                  </td>
                  <td style="text-align: right">
                    @php
                    $total_discount = array_sum($discount_value_holder_history) + $bo_allowance;
                    $sum_total_discount[] = $total_discount;
                    @endphp
                    {{  number_format($total_discount,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                    $final_total_cost = $total_amount - $total_discount;
                    $sum_final_total_cost[] = $final_total_cost;
                    @endphp
                    {{  number_format($final_total_cost,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                    $final_unit_cost = $final_total_cost / $data->quantity_per_sku;
                    $sum_final_unit_cost[] = $final_unit_cost;
                    @endphp
                    {{  number_format($final_unit_cost,2,".",",") }}
                  </td>
                  <td style="text-align: right">{{ $data->remarks }}</td>
                  <td style="text-align: right">{{ $data->expiration_date }}</td>
                </tr>
               @endforeach
              <tr>
                <td style="text-align: center;font-weight: bold" colspan="5">GRAND TOTAL</td>
                <td style="text-align: right;font-weight: bold"> {{  number_format(array_sum($sum_total_amount),2,".",",") }}</td>
                @php
                  $sum_total = array_sum($sum_total_amount);
                  $sum_discount_value_holder = $sum_total;
                  $sum_discount_value_holder_history = [];
                  $sum_discount_value_holder_history_for_bo_allowance = [];
                  $totalArray = [];
                  $percent = [];
                  foreach($principal_discount_details as $data_discount) {
                    $sum_discount_value_holder_dummy = $sum_discount_value_holder;
                    $less_percentage_by = ($data_discount->discount_rate / 100);
                    $discount_rate_answer = $sum_discount_value_holder * $less_percentage_by;
                    $sum_discount_value_holder = $sum_discount_value_holder - $sum_discount_value_holder_dummy * $less_percentage_by;
                    
                    $sum_discount_value_holder_history[] = $discount_rate_answer;
                    $sum_discount_value_holder_history_for_bo_allowance[] = $sum_discount_value_holder;
                    echo '<td style="text-align:right;">'. number_format($discount_rate_answer,2,".",",") .'</td>';
                  }
                @endphp
                <td style="text-align: right;font-weight: bold">{{  number_format(array_sum($sum_bo_allowance),2,".",",") }}
                </td>
                <td style="text-align: right;font-weight: bold">{{  number_format(array_sum($sum_total_discount),2,".",",") }}
                </td>
                <td style="text-align: right;font-weight: bold"> {{  number_format(array_sum($sum_final_total_cost),2,".",",") }}</td>
                <td></td>
              </tr>
            </tbody>
          </table>
        @elseif($principal_name == 'DOLE')
          <table class="table table-bordered table-hover" style="font-size: 12px;">
            <thead>
              <tr>
                <th style="text-align: center;">SKU CODE</th>
                <th style="text-align: center;">DESC</th>
                <th style="text-align: center;">QTY RCVD</th>
                <th style="text-align: center;">UOM</th>
                <th style="text-align: center;">U/C</th>
                <th style="text-align: center;">TOTAL AMOUNT <br /> <i>VAT EXCLUSIVE</i></th>
                <th style="text-align: center;">DISCOUNT<br /> </th>
                <th style="text-align: center;">BO ALLOWANCE </th>
                <th style="text-align: center;">VAT</th>
                <th style="text-align: center;">FINAL TOTAL COST</th>
                <th style="text-align: center;">FINAL UNIT COST</th>
                <th style="text-align: center;">EXPIRATION</th>
                <th style="text-align: center;">RMRKS</th>
              </tr>
            </thead>
            <tbody>
              @foreach($received_details as $data)
              <tr>
                <td>{{ $data->sku->sku_code }}</td>
                <td>{{ $data->sku->description }}</td>
                <td>{{ $data->quantity_per_sku }}</td>
                <td>{{ $data->sku->unit_of_measurement }}</td>
                <td style="text-align: right;">{{ number_format($data->unit_cost_per_sku,2,".",",")  }}</td>
                <td style="text-align: right;">
                  @php
                  $vatable_purchase_per_sku = $data->unit_cost_per_sku * $data->quantity_per_sku;
                  $sum_vatable_purchase_per_sku[] = $vatable_purchase_per_sku;
                  @endphp
                  {{ number_format($vatable_purchase_per_sku, 2, '.', ',') }}
                </td>
                <td style="text-align: right;">
                  @php
                  $discount_per_sku =  $vatable_purchase_per_sku * ($principal_discount->total_discount / 100);
                  $sum_discount_per_sku[] = $discount_per_sku;
                  @endphp
                  {{ number_format($discount_per_sku, 2, '.', ',') }}
                 
                </td>
                <td style="text-align: right;">
                  @php
                  $bo_allowance_per_sku =  $vatable_purchase_per_sku * ($principal_discount->total_bo_allowance_discount / 100);
                  $sum_bo_allowance_per_sku[] = $bo_allowance_per_sku;
                  @endphp
                  {{ number_format($bo_allowance_per_sku, 2, '.', ',') }}
                 
                </td>
                <td style="text-align: right;">
                  @php
                  $vat_amount_per_sku = ($vatable_purchase_per_sku - $discount_per_sku - $bo_allowance_per_sku)*.12;
                  $sum_vat_amount_per_sku[] = $vat_amount_per_sku;
                  @endphp
                  {{ number_format($vat_amount_per_sku, 2, '.', ',') }}
                </td>
                <td style="text-align: right;">
                  @php
                  $final_total_cost = $vatable_purchase_per_sku - $discount_per_sku - $bo_allowance_per_sku + $vat_amount_per_sku;
                  $sum_final_total_cost[] = $final_total_cost;
                  @endphp
                  {{ number_format($final_total_cost, 2, '.', ',') }}
                  
                </td>
                <td style="text-align: right;">
                  @php
                  $final_unit_cost = $final_total_cost / $data->quantity_per_sku;
                  $sum_final_unit_cost[] = $final_unit_cost;
                  @endphp
                  {{ number_format($final_unit_cost,2,".",",") }}
                 
                </td>
                <td style="text-align: center;">{{ $data->expiration_date }}</td>
                <td style="text-align: center;">{{ $data->remarks }}</td>
              </tr>
              @endforeach
              <tr>
                <td colspan="5" style="font-weight: bold;text-align: center;">GRAND TOTAL</td>
                <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_vatable_purchase_per_sku),2,".",",") }}</td>
                <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_discount_per_sku),2,".",",") }}</td>
                <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_bo_allowance_per_sku),2,".",",") }}</td>
                <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_vat_amount_per_sku),2,".",",") }}</td>
                <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_final_total_cost),2,".",",") }}</td>
                <td colspan="3"></td>
              </tr>
            </tbody>
          </table>
        @else
            <table class="table table-bordered table-hover" style="font-size: 12px;">
              <thead>
                <tr>
                  <th style="text-align: center;">CODE</th>
                  <th style="text-align: center;">DESC</th>
                  <th style="text-align: center;">QTY<br />RCVD</th>
                  <th style="text-align: center;">UOM</th>
                  <th style="text-align: center;">U/C</th>
                  <th style="text-align: center;">TOTAL AMOUNT <br /> <i>VAT INCLUSIVE</i></th>
                  <th style="text-align: center;">VATABLE <br /> <i>PURCHASE</i></th>
                  <th style="text-align: center;">DISCOUNT</th>
                  <th style="text-align: center;">BO<br />ALLOWANCE</th>
                  <th style="text-align: center;">VAT<br />AMOUNT</th>
                  <th style="text-align: center;">FINAL TOTAL <br />COST</th>
                  <th style="text-align: center;">FINAL UNIT <br />COST</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($received_details as $data)
                    <tr>
                      <td style="text-align: center;">{{ $data->sku->sku_code }}</td>
                      <td style="text-align: center;">{{ $data->sku->description }}</td>
                      <td style="text-align: center;">{{ $data->quantity_per_sku }}</td>
                      <td style="text-align: center;">{{ $data->sku->unit_of_measurement }}</td>
                      <td style="text-align: right;">{{ number_format($data->unit_cost_per_sku,2,".",",")  }}</td>
                      <td style="text-align: right;">
                          @php
                            $total_amount_per_sku = $data->unit_cost_per_sku * $data->quantity_per_sku;
                            $sum_total_amount_per_sku[] = $total_amount_per_sku;
                          @endphp
                          {{ number_format($total_amount_per_sku,2,".",",") }}
                      </td>
                      <td style="text-align: right;">
                          @php
                            $vatable_purchase_per_sku = $total_amount_per_sku / 1.12;
                            $sum_vatable_purchase_per_sku[] = $vatable_purchase_per_sku;
                          @endphp
                          {{ number_format($vatable_purchase_per_sku,2,".",",") }}
                      </td>
                      <td style="text-align: right;">
                         @php
                          $discount_per_sku = $vatable_purchase_per_sku * $principal_discount->total_discount/100;
                          $sum_total_discount_per_sku[] = $discount_per_sku;
                          @endphp
                          {{ number_format($discount_per_sku,2,".",",") }}
                      </td>
                      <td style="text-align: right;">
                        @php
                          $bo_allowance_per_sku = $vatable_purchase_per_sku*($principal_discount->total_bo_allowance_discount/100);
                          $sum_bo_allowance_per_sku[] = $bo_allowance_per_sku;
                        @endphp
                        {{ number_format($bo_allowance_per_sku,2,".",",") }}
                      </td>
                      <td style="text-align: right;">
                        @php
                          $vat_amount_per_sku = ($vatable_purchase_per_sku - $discount_per_sku - $bo_allowance_per_sku)*.12;
                          $sum_vat_amount_per_sku[] = $vat_amount_per_sku;
                        @endphp
                        {{ number_format($vat_amount_per_sku,2,".",",") }}
                      </td>
                      <td style="text-align: right;">
                        @php
                          $final_total_cost_per_sku = $vatable_purchase_per_sku - $discount_per_sku - $bo_allowance_per_sku + $vat_amount_per_sku;
                          $sum_final_total_cost_per_sku[] = $final_total_cost_per_sku;
                        @endphp
                        {{ number_format($final_total_cost_per_sku,2,".",",") }}
                      </td>
                      <td style="text-align: right;">
                        @php
                          $final_unit_cost_per_sku = $final_total_cost_per_sku / $data->quantity_per_sku;
                          $sum_final_unit_cost_per_sku[] = $final_unit_cost_per_sku;
                        @endphp
                        {{ number_format($final_unit_cost_per_sku,2,".",",") }}
                      </td>
                    </tr>
                  @endforeach
                    <tr>
                      <td colspan="5" style="font-weight: bold;text-align: center;">GRAND TOTAL</td>
                      <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_total_amount_per_sku),2,".",",") }}</td>
                      <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_vatable_purchase_per_sku),2,".",",") }}</td>
                      <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_total_amount_per_sku),2,".",",") }}</td>
                      <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_bo_allowance_per_sku),2,".",",") }}</td>
                      <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_vat_amount_per_sku),2,".",",") }}</td>
                      <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_final_total_cost_per_sku),2,".",",") }}</td>
                      <td colspan="2"></td>
                    </tr>
              </tbody>
            </table>
        @endif
      </div>

        @if($principal_name == 'CIFPI')
          <div class="col-sm-4 invoice-col">
            <table class="table table-bordered table-hover float-right" style="font-size: 12px;">
              <tr>
                <td style="font-weight: bold; text-align: left;width:50%;">SUMMARY:</td>
                <td></td>
              </tr>
              <tr>
                <td style="font-weight: bold; text-align: left;width:50%;text-align: center;">GROSS PURCHASES:</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                  @php
                  $gross_purchase = array_sum($sum_total_amount_per_sku);
                  @endphp
                  {{ number_format($gross_purchase,2,".",",") }}
                </td>
              </tr>
              @php
                $total = $gross_purchase;
                $discount_value_holder = $total;
                $discount_value_holder_history = [];
                $less_discount_value_holder_history_for_bo_allowance = [];
                $totalArray = [];
                $percent = [];
                foreach($principal_discount_details as $data_discount) {
                  echo '<tr><td style="text-align:right"> Less '. $data_discount->discount_rate / 100 .'% </td>';
                  $discount_value_holder_dummy = $discount_value_holder;
                  $less_percentage_by = ($data_discount->discount_rate / 100);
                  // $discount_value_holder = $discount_value_holder_dummy - ($discount_value_holder_dummy * $less_percentage_by);
                  $less_discount_rate_answer = $discount_value_holder * $less_percentage_by;
                  $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                  $less_discount_value_holder_history[] = $less_discount_rate_answer;
                  $less_discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                  echo '<td style="text-align:right;">'. number_format($less_discount_rate_answer,2,".",",") .'</td></tr>';
                }
              @endphp
              <tr>
                <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">TOTAL <br />DISCOUNT: </td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                  {{ number_format(array_sum($less_discount_value_holder_history),2,".",",") }}
                </td>
              </tr>
              <tr>
                <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">BO <br />ALLOWANCE: {{ number_format($principal_discount->total_bo_allowance_discount,2,".",",") }} %</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                  @php
                  $less_bo_allowance = end($less_discount_value_holder_history_for_bo_allowance) - (end($less_discount_value_holder_history_for_bo_allowance) * ($principal_discount->total_bo_allowance_discount/100));
                  $less_bo_allowance_per_summary = end($less_discount_value_holder_history_for_bo_allowance) - $less_bo_allowance;
                  @endphp
                  {{ number_format($less_bo_allowance_per_summary,2,".",",") }}
                </td>
              </tr>
              <tr>
                <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">VATABLE<br />PURCHASE:</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                  @php
                  $net_discount = $gross_purchase - (array_sum($less_discount_value_holder_history) + $less_bo_allowance_per_summary);
                  @endphp
                  {{ number_format($net_discount,2,".",",") }}
                  
                </td>
              </tr>
              <tr>
                <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">ADD VAT: 12%</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                  @php
                  $less_vat = ($net_discount - ($net_discount*1.12))*-1;
                  
                  @endphp
                  {{ number_format($less_vat,2,".",",") }}
                  
                </td>
              </tr>
              <tr>
                <td style="text-align: left;width:50%;font-weight: bold;text-align: center">FREIGHT</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                  @php
                  $freight  = array_sum($sum_freight_per_sku);
                  
                  @endphp
                  {{ number_format($freight,2,".",",") }}
                  
                </td>
              </tr>
              <tr>
                <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">TOTAL</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;font-weight: bold">
                  @php
                  $total  =  $gross_purchase - (array_sum($less_discount_value_holder_history) + $less_bo_allowance_per_summary);
                  $grand_total_final_cost =  $total + $less_vat + $freight;
                  
                  @endphp
                  {{ number_format($grand_total_final_cost,2,".",",") }}
                </td>
              </tr>
            </table>
          </div>
          <div class="col-sm-8">
            <table class="table table-bordered table-hovered" style="width:100%;font-size: 12px;">
              <thead>
                <tr>
                  <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                  <th style="text-align: center;">DR</th>
                  <th style="text-align: center;">CR</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align: center;">INVENTORY GCI</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;"><?php echo number_format($grand_total_final_cost, 2, '.', ','); ?></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td style="text-align: center;">ACCOUNTS PAYABLE - GCI</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;"><?php echo number_format($grand_total_final_cost, 2, '.', ','); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        @elseif($principal_name == 'PPMC')
          <div class="col-sm-4 invoice-col">
            <table class="table table-bordered table-hover float-right" style="font-size: 12px;">
              <tr>
                <td style="font-weight: bold; text-align: left;width:50%;">SUMMARY:</td>
                <td></td>
              </tr>
              <tr>
                <td style="font-weight: bold; text-align: left;width:50%;">VATABLE PURCHASE:</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                  @php
                  $vatable_purchase = array_sum($sum_total_amount)/1.12;
                  @endphp
                  {{ number_format($vatable_purchase,2,".",",") }}
                 
                </td >
              </tr>
              <tr>
                <td style="text-align: left;width:50%;">LESS: DISCOUNTS</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                  @php
                  $less_discount = array_sum($sum_total_discount)/1.12;
                  @endphp
                  {{ number_format($less_discount*-1,2,".",",") }}
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold;">NET OF DISCOUNTS</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                  @php
                  $net_discount = $vatable_purchase - $less_discount;
                  @endphp
                  {{ number_format($net_discount,2,".",",") }}
                </td>
              </tr>
              <tr>
                <td>VAT AMOUNT</td>
                <td style="text-align: right;font-size: 15px;">
                  @php
                  $vat_amount = array_sum($sum_final_total_cost)/1.12*0.12;
                  @endphp
                  {{ number_format($vat_amount,2,".",",") }}
                  
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold;">TOTAL FINAL COST</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                  @php
                  $grand_total_final_cost = $net_discount + $vat_amount;
                  @endphp
                  {{ number_format($grand_total_final_cost,2,".",",") }}
                
                </td>
              </tr>
            </table>
          </div>
          <div class="col-sm-8 invoice-col">
            <table class="table table-bordered table-hovered" style="font-size:12px;">
              <thead>
                <tr>
                  <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                  
                  <th style="text-align: center;">DR</th>
                  <th style="text-align: center;">CR</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align: center;">INVENTORY PPMC</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;"><?php echo number_format($grand_total_final_cost, 2, '.', ','); ?></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td style="text-align: center;">ACCOUNTS PAYABLE - PPMC</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;"><?php echo number_format($grand_total_final_cost, 2, '.', ','); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        @elseif($principal_name == 'DOLE')
          <div class="col-sm-4 invoice-col">
            <table class="table table-bordered table-hover" style="font-size: 12px;">
              <tr>
                <td style="font-weight: bold; text-align: left;width:50%;">SUMMARY:</td>
                <td></td>
              </tr>
              <tr>
                <td style="font-weight: bold; text-align: left;width:50%;">VATABLE PURCHASE:</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                  @php
                  $vatable_purchase = array_sum($sum_vatable_purchase_per_sku);
                  @endphp
                  {{  number_format($vatable_purchase,2,".",",") }}
                  <input type="hidden" name="total_vatable_purchase" value="{{ $vatable_purchase }}">
                </td >
              </tr>
              <tr>
                <td style="text-align: left;width:50%;">LESS: DISCOUNTS</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                  @php
                  $less_discount = array_sum($sum_discount_per_sku) + array_sum($sum_bo_allowance_per_sku);
                  @endphp
                  {{  number_format($less_discount*-1,2,".",",") }}
                  <input type="hidden" name="total_discount" value="{{ $less_discount }}">
                  <input type="hidden" name="total_bo_allowance_discount" value="{{ array_sum($sum_bo_allowance_per_sku) }}">
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold;">NET OF DISCOUNTS</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                  @php
                  $net_discount = $vatable_purchase - $less_discount;
                  @endphp
                  {{  number_format($net_discount,2,".",",") }}
                  
                </td>
              </tr>
              <tr>
                <td>VAT AMOUNT</td>
                <td style="text-align: right;font-size: 15px;">
                  @php
                  $vat_amount = $net_discount*0.12;
                  @endphp
                  {{  number_format($vat_amount,2,".",",") }}
                  <input type="hidden" name="total_vat_amount" value="{{ $vat_amount }}">
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold;">FINAL TOTAL COST</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                  @php
                  $grand_final_total_cost = $net_discount + $vat_amount;
                  @endphp
                  {{  number_format($grand_final_total_cost,2,".",",") }}
                  <input type="hidden" name="grand_total_final_cost" value="{{ $grand_final_total_cost }}">
                </td>
              </tr>
            </table>
          </div>
          <div class="col-sm-8 invoice-col">
            <table class="table table-bordered table-hovered" style="width:100%;font-size: 12px;">
              <thead>
                <tr>
                  <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                  <th style="text-align: center;">DR</th>
                  <th style="text-align: center;">CR</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align: center;">INVENTORY GCI</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;"><?php echo number_format($grand_final_total_cost, 2, '.', ','); ?></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td style="text-align: center;">ACCOUNTS PAYABLE - GCI</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;"><?php echo number_format($grand_final_total_cost, 2, '.', ','); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        @else
          <div class="col-sm-4 invoice-col">
            <table class="table table-bordered table-hovered" style="font-size: 12px;">
              <tr>
                <td style="font-weight: bold; text-align: left;width:50%;">SUMMARY:</td>
                <td></td>
              </tr>
              <tr>
                <td style="font-weight: bold; text-align: left;width:50%;">VATABLE PURCHASE:</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                  @php
                  $vatable_purchase = array_sum($sum_total_amount_per_sku)/1.12;
                  @endphp
                  {{  number_format($vatable_purchase,2,".",",") }}
                  <input type="hidden" name="vatablePurchase" value="">
                </td >
              </tr>
              <tr>
                <td style="text-align: left;width:50%;">LESS: DISCOUNTS</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                  @php
                  $less_discount = (array_sum($sum_total_discount_per_sku) +  array_sum($sum_bo_allowance_per_sku));
                  @endphp
                  {{  number_format($less_discount*-1,2,".",",") }}
                  <input type="hidden" name="lessDiscounts" value="">
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold;">NET OF DISCOUNTS</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                  @php
                  $net_discount = $vatable_purchase - $less_discount;
                  @endphp
                  {{  number_format($net_discount,2,".",",") }}
                  <input type="hidden" name="netDiscount" value="">
                </td>
              </tr>
              <tr>
                <td>VAT AMOUNT</td>
                <td style="text-align: right;font-size: 15px;">
                  @php
                  $vat_amount = $net_discount*0.12;
                  @endphp
                  {{  number_format($vat_amount,2,".",",") }}
                  <input type="hidden" name="vatAmount" value="">
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold;">FINAL TOTAL COST</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                  @php
                  $grand_final_total_cost = $vatable_purchase - array_sum($sum_total_discount_per_sku) - array_sum($sum_bo_allowance_per_sku) + $vat_amount;
                  @endphp
                  {{  number_format($grand_final_total_cost,2,".",",") }}
                </td>
              </tr>
            </table> 
          </div>
          <div class="col-sm-8 invoice-col">
            <table class="table table-bordered table-hovered" style="width:100%;font-size: 12px;">
              <thead>
                <tr>
                  <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                  <th style="text-align: center;">DR</th>
                  <th style="text-align: center;">CR</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align: center;">INVENTORY GCI</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;"><?php echo number_format($grand_final_total_cost, 2, '.', ','); ?></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td style="text-align: center;">ACCOUNTS PAYABLE - GCI</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;"><?php echo number_format($grand_final_total_cost, 2, '.', ','); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        @endif
    <!-- /.col -->
      </div>
  <!-- /.row -->
  
  
  <!-- /.row -->
</section>
<!-- /.content -->
</div>
{{-- <script type="text/javascript">
window.addEventListener("load", window.print());
</script> --}}