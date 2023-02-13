@if($principal_name == 'CIFPI')
      <form class="save_form" id="save_form" name="save_form">
<p>{{ $branch }} <input type="hidden" name="branch" value="{{ $branch }}"></p>
<div class="table table-responsive">


  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th colspan="{{ $selected_discount_counter + 1 }}" style="text-align: center">DISCOUNT ALLOCATION</th>
      </tr>
      <tr>
        @foreach($selected_discount_rate as $data)
          <th style="text-align: center;">{{ ucfirst($data->discount_name) }}</th>
        @endforeach
          <th style="text-align: center;">Bo allowance</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        @foreach($selected_discount_rate as $data)
          <td style="text-align: center;">{{ $data->discount_rate ."%" }}</td>
        @endforeach 
          <td style="text-align: center;">{{ $selected_discount_allocation->total_bo_allowance_discount ."%" }}</td>
      </tr>
    </tbody>
  </table>
  <table class="table table-hover table-bordered" style="font-size:15px;">
    <thead>
      <tr>
        <th style="text-align: center;">Code</th>
        <th style="text-align: center;">DESC</th>
        <th style="text-align: center;width:40px;">QTY</th>
        <th style="text-align: center;">UOM</th>
        <th style="text-align: center;">U/C</th>
        <th style="text-align: center;">TOTAL<br />AMOUNT<br />VAT<br />EXCLUSIVE</th>
        @foreach($selected_discount_rate as $data)
        <th style="text-align: center;">{{ ucfirst($data->discount_name) }}<br />{{ $data->discount_rate }} %</th>
        @endforeach
        <th style="text-align: center;">BO ALLOWANCE {{ $selected_discount_allocation->total_bo_allowance_discount }} %</th>
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
      @foreach($sku_id as $data)
        @if($received_quantity[$data] != 0)
          <tr>
          <td>
            {{ $sku_code[$data] }}
            <input type="hidden" name="sku_id[]" value="{{ $data }}">
          </td>
          <td>{{ $description[$data] }}</td>
          <td>
            {{ $received_quantity[$data] }}
            <input type="hidden" name="quantity_per_sku[{{ $data }}]" value="{{ $received_quantity[$data] }}">
          </td>
          <td>{{ $unit_of_measurement[$data] }}</td>
          <td style="text-align: right;">
            {{ number_format($unit_cost[$data],2,".",",") }}
            <input type="hidden" name="unit_cost_per_sku[{{ $data }}]" value="{{ $unit_cost[$data] }}">
            <input type="hidden" name="price_1[{{ $data }}]" value="{{ $price_1[$data] }}">
            <input type="hidden" name="price_2[{{ $data }}]" value="{{ $price_2[$data] }}">
            <input type="hidden" name="price_3[{{ $data }}]" value="{{ $price_3[$data] }}">
            <input type="hidden" name="price_4[{{ $data }}]" value="{{ $price_4[$data] }}">
            <input type="hidden" name="category_id[{{ $data }}]" value="{{ $category_id[$data] }}">
            <input type="hidden" name="sku_type[{{ $data }}]" value="{{ $sku_type[$data] }}">
          </td>
          <td style="text-align: right;">
              @php
                $total_amount_per_sku = $received_quantity[$data] * $unit_cost[$data];
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
              foreach($selected_discount_rate as $data_discount) {
              
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
                $bo_allowance = end($discount_value_holder_history_for_bo_allowance) -  end($discount_value_holder_history_for_bo_allowance) * ($selected_discount_allocation->total_bo_allowance_discount/100);
                $bo_allowance_per_sku = end($discount_value_holder_history_for_bo_allowance) - $bo_allowance;
                $sum_bo_allowance_per_sku[] = $bo_allowance_per_sku;
              @endphp
               {{ number_format($bo_allowance_per_sku,2,".",",") }}
               <input type="hidden" name="bo_allowance_discount_per_sku[{{ $data }}]" value="{{ $bo_allowance_per_sku }}">
               <input type="hidden" name="bo_allowance_discount_rate_per_sku[{{ $data }}]" value="{{ $selected_discount_allocation->total_bo_allowance_discount }}">
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
               $freight_per_sku = $freight[$data] * $received_quantity[$data];
               $sum_freight_per_sku[] = $freight_per_sku;
              @endphp
              {{  number_format($freight_per_sku,2,".",",") }}
              <input type="hidden" name="freight_per_sku[{{ $data }}]" value="{{ $freight_per_sku
               }}">
              
          </td>
          <td style="text-align: right">
              @php
                $final_total_cost_per_sku = $vat_inclusive_total_cost_per_sku + $freight_per_sku;
                $sum_final_total_cost_per_sku[] = $final_total_cost_per_sku;
              @endphp
              {{  number_format($final_total_cost_per_sku,2,".",",") }}
              <input type="hidden" name="final_total_cost_per_sku[{{ $data }}]" value="{{ $final_total_cost_per_sku }}">
          </td>
          <td style="text-align: right">
              @php
                $final_unit_cost_per_sku = $final_total_cost_per_sku / $received_quantity[$data];
              @endphp
              {{  number_format($final_unit_cost_per_sku,2,".",",") }}
              <input type="hidden" name="final_unit_cost_per_sku[{{ $data }}]" value="{{ $final_unit_cost_per_sku }}">
          </td>
          <td style="text-align:center">
            {{ $remarks[$data] }}
            <input type="hidden" name="remarks[{{ $data }}]" value="{{ $remarks[$data] }}">
          </td>
          <td style="text-align: right">
              {{ $expiration_date[$data] }}
              <input type="hidden" name="expiration_date[{{ $data }}]" value="{{ $expiration_date[$data] }}">
            </td>
          </tr>
        @else

        @endif
      @endforeach
       <tr>
          <td colspan="5" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
          <td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_total_amount_per_sku),2,".",",") }}
              <input type="hidden" name="total_vatable_purchase" value="{{ array_sum($sum_total_amount_per_sku) }}">
          </td>
          @php
              $total = array_sum($sum_total_amount_per_sku);
             
              $discount_value_holder = $total;
              $discount_value_holder_history = [];
              
              $totalArray = [];
              $percent = [];
              foreach($selected_discount_rate as $data_discount) {
              
                $discount_value_holder_dummy = $discount_value_holder;
                $less_percentage_by = ($data_discount->discount_rate / 100);
                
                // $discount_value_holder = $discount_value_holder_dummy - ($discount_value_holder_dummy * $less_percentage_by);
                $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                
                $discount_value_holder_history[] = $discount_rate_answer;
                echo '<td style="text-align:right;">'. number_format($discount_rate_answer,2,".",",") .'</td>';
          @endphp
              <input type="hidden" name="discount_rate_per_sku[]" value="{{ $data_discount->discount_rate }}">
          @php
              }
          @endphp
          <td style="text-align: right;font-weight: bold">
            {{ number_format(array_sum($sum_bo_allowance_per_sku),2,".",",") }}
            <input type="hidden" name="total_bo_allowance_discount" value="{{ array_sum($sum_bo_allowance_per_sku) }}">
          </td>
          <td style="text-align: right;font-weight: bold">
            {{ number_format(array_sum($sum_vat_per_sku),2,".",",") }}
            <input type="hidden" name="total_vat_amount" value="{{ array_sum($sum_vat_per_sku) }}">
          </td>
          <td style="text-align: right;font-weight: bold">

            {{ number_format(array_sum($sum_vat_inclusive_total_cost_per_sku),2,".",",") }}
          </td>
          <td style="text-align: right;font-weight: bold">
            {{ number_format(array_sum($sum_freight_per_sku),2,".",",") }}
             <input type="hidden" name="total_freight" value="{{ array_sum($sum_freight_per_sku) }}">
          </td>
          <td style="text-align: right;font-weight: bold">
            {{ number_format(array_sum($sum_final_total_cost_per_sku),2,".",",") }}
             <input type="hidden" name="grand_total_final_cost" value="{{ array_sum($sum_final_total_cost_per_sku) }}">
          </td>
        </tr>
    </tbody>
  </table>

  <table class="table table-bordered table-hover float-right" style="width:30%;">
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
      foreach($selected_discount_rate as $data_discount) {
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
        <input type="hidden" name="total_discount" value="{{ array_sum($less_discount_value_holder_history) }}">
      </td>
    </tr>
    <tr>
      <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">BO <br />ALLOWANCE: {{ number_format($selected_discount_allocation->total_bo_allowance_discount,2,".",",") }} %</td>
      <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
        @php
        $less_bo_allowance = end($less_discount_value_holder_history_for_bo_allowance) - (end($less_discount_value_holder_history_for_bo_allowance) * ($selected_discount_allocation->total_bo_allowance_discount/100));
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
        <input type="hidden" name="grand_total_final_cost" value="{{ $grand_total_final_cost }}">
        
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
     <div class="form-group">
        
          <input type="hidden" name="principal_id" value="{{ $principal_id }}">
          <input type="hidden" name="purchase_order_id" value="{{ $purchase_order_id }}">
          <input type="hidden" name="dr_si" value="{{ $dr_si }}">
          <input type="hidden" name="truck_number" value="{{ $truck_number }}">
          <input type="hidden" name="courier" value="{{ $courier }}">
          <input type="hidden" name="principal_name" value="{{ $principal_name }}">
          <input type="hidden" name="purchase_id" value="{{ $purchase_id }}">
          <input type="hidden" name="principal_discount_id" value="{{ $selected_discount_allocation->id }}">
          <input type="hidden" name="invoice_date" value="{{ $invoice_date }}">
        
          <div class="col-md-12">
              <button class="float-right btn btn-success btn-flat btn-sm btn-block" type="button" onclick="return save_data()" style="font-weight: bold;">SAVE DATA</button>
          </div>
    </div>
 
  </form>
  </div>

















































































@elseif($principal_name == 'PPMC')
<form action="post" class="save_form" id="save_form" name="save_form">
<p>{{ $branch }} <input type="hidden" name="branch" value="{{ $branch }}"></p>
  <div class="table table-responsive">
  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th colspan="{{ $selected_discount_counter + 1 }}" style="text-align: center">DISCOUNT ALLOCATION</th>
      </tr>
      <tr>
        @foreach($selected_discount_rate as $data)
          <th style="text-align: center;">{{ ucfirst($data->discount_name) }}</th>
        @endforeach
          <th style="text-align: center;">Bo allowance</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        @foreach($selected_discount_rate as $data)
          <td style="text-align: center;">{{ $data->discount_rate ."%" }}</td>
        @endforeach 
          <td style="text-align: center;">{{ $selected_discount_allocation->total_bo_allowance_discount ."%" }}</td>
      </tr>
    </tbody>
  </table>
  
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th style="text-align: center;">CODE</th>
          <th style="text-align: center;">DESC</th>
          <th style="text-align: center;">QTY<br />RCVD</th>
          <th style="text-align: center;">UOM</th>
          <th style="text-align: center;">U/C</th>
          <th style="text-align: center;">TOTAL AMNT <br /><i>Vat Inclusive</i></th>
          @foreach($selected_discount_rate as $data)
          <th style="text-align: center;">{{ ucfirst($data->discount_name) }}<br /> {{ $data->discount_rate }} %</th>
          @endforeach
          <th style="text-align: center;">BO<br />ALLOW<br />{{ $selected_discount_allocation->total_bo_allowance_discount }} %</th>
          <th style="text-align: center;">TOTAL DISCOUNT<br />(VAT INC)</th>
          <th style="text-align: center;">FTC</th>
          <th style="text-align: center;">FUC</th>
          <th style="text-align: center;">RMRKS</th>
          <th style="text-align: center;">EXP DATE</th>

        </tr>
      </thead>
      <tbody>
        @foreach($sku_id as $data)
          @if($received_quantity[$data] != 0)

          <tr>
            <td>
              {{ $sku_code[$data] }}
              <input type="hidden" name="sku_id[]" value="{{ $data }}">
            </td>
            <td>{{ $description[$data] }}</td>
            <td>
              {{ $received_quantity[$data] }}
              <input type="hidden" name="quantity_per_sku[{{ $data }}]" value="{{ $received_quantity[$data] }}">
            </td>
            <td>{{ $unit_of_measurement[$data] }}</td>
            <td style="text-align: right;">
              {{ number_format($unit_cost[$data],2,".",",") }}
              <input type="hidden" name="unit_cost_per_sku[{{ $data }}]" value="{{ $unit_cost[$data] }}">
              <input type="hidden" name="price_1[{{ $data }}]" value="{{ $price_1[$data] }}">
              <input type="hidden" name="price_2[{{ $data }}]" value="{{ $price_2[$data] }}">
              <input type="hidden" name="price_3[{{ $data }}]" value="{{ $price_3[$data] }}">
              <input type="hidden" name="price_4[{{ $data }}]" value="{{ $price_4[$data] }}">
              <input type="hidden" name="category_id[{{ $data }}]" value="{{ $category_id[$data] }}">
              <input type="hidden" name="sku_type[{{ $data }}]" value="{{ $sku_type[$data] }}">
            </td>
            <td style="text-align: right">
                  @php
                    $total_amount = $received_quantity[$data] * $unit_cost[$data];
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
              foreach($selected_discount_rate as $data_discount) {
              
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
              $bo_allowance = $total_amount * $selected_discount_allocation->total_bo_allowance_discount/100;
              $sum_bo_allowance[] = $bo_allowance;
              @endphp
              {{  number_format($bo_allowance,2,".",",") }}
              <input type="hidden" name="bo_allowance_discount_per_sku[{{ $data }}]" value="{{ $bo_allowance }}">
              <input type="hidden" name="bo_allowance_discount_rate_per_sku[{{ $data }}]" value="{{ $selected_discount_allocation->total_bo_allowance_discount }}">
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
              <input type="hidden" name="final_total_cost_per_sku[{{ $data }}]" value="{{ $final_total_cost }}">
            </td>
            <td style="text-align: right">
              @php
              $final_unit_cost = $final_total_cost / $received_quantity[$data];
              $sum_final_unit_cost[] = $final_unit_cost;
              @endphp
              {{  number_format($final_unit_cost,2,".",",") }}
              <input type="hidden" name="final_unit_cost_per_sku[{{ $data }}]" value="{{ $final_unit_cost }}">
            </td>
            <td style="text-align: right">
              {{ $remarks[$data] }}
              <input type="hidden" name="remarks[{{ $data }}]" value="{{ $remarks[$data] }}">
            </td>
            <td style="text-align: right">
              {{ $expiration_date[$data] }}
              <input type="hidden" name="expiration_date[{{ $data }}]" value="{{ $expiration_date[$data] }}">
            </td>
          </tr>
          @else

          @endif
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
              foreach($selected_discount_rate as $data_discount) {
              
                $sum_discount_value_holder_dummy = $sum_discount_value_holder;
                $less_percentage_by = ($data_discount->discount_rate / 100);
                
                // $sum_discount_value_holder = $sum_discount_value_holder_dummy - ($sum_discount_value_holder_dummy * $less_percentage_by);
                $discount_rate_answer = $sum_discount_value_holder * $less_percentage_by;
                $sum_discount_value_holder = $sum_discount_value_holder - $sum_discount_value_holder_dummy * $less_percentage_by;
                
                $sum_discount_value_holder_history[] = $discount_rate_answer;
                $sum_discount_value_holder_history_for_bo_allowance[] = $sum_discount_value_holder;
                echo '<td style="text-align:right;">'. number_format($discount_rate_answer,2,".",",") .'</td>';
          @endphp
              <input type="hidden" name="discount_rate_per_sku[]" value="{{ $data_discount->discount_rate }}">
          @php
              }
          @endphp
               <td style="text-align: right;font-weight: bold"> 
                {{  number_format(array_sum($sum_bo_allowance),2,".",",") }}
                <input type="hidden" name="total_bo_allowance_discount" value="{{ array_sum($sum_bo_allowance) }}">
               </td>
               <td style="text-align: right;font-weight: bold"> 
                {{  number_format(array_sum($sum_total_discount),2,".",",") }}
                <input type="hidden" name="total_discount" value="{{ array_sum($discount_value_holder_history) }}">
               </td>
               <td style="text-align: right;font-weight: bold"> {{  number_format(array_sum($sum_final_total_cost),2,".",",") }}</td>
               <td></td>
          </tr>
      </tbody>
    </table>
    <table class="table table-bordered table-hover float-right" style="width:30%;">
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
            <input type="hidden" name="total_vatable_purchase" value="{{ $vatable_purchase }}">
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
            <input type="hidden" name="total_vat_amount" value="{{ $vat_amount }}">
          </td>
        </tr>
        <tr>
          <td style="font-weight: bold;">TOTAL FINAL COST</td>
          <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
            @php
              $grand_total_final_cost = $net_discount + $vat_amount;
            @endphp
            {{ number_format($grand_total_final_cost,2,".",",") }}
            <input type="hidden" name="grand_total_final_cost" value="{{ $grand_total_final_cost }}">
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
    <div class="form-group">
        
          <input type="hidden" name="principal_id" value="{{ $principal_id }}">
          <input type="hidden" name="purchase_order_id" value="{{ $purchase_order_id }}">
          <input type="hidden" name="dr_si" value="{{ $dr_si }}">
          <input type="hidden" name="truck_number" value="{{ $truck_number }}">
          <input type="hidden" name="courier" value="{{ $courier }}">
          <input type="hidden" name="principal_name" value="{{ $principal_name }}">
          <input type="hidden" name="purchase_id" value="{{ $purchase_id }}">
          <input type="hidden" name="principal_discount_id" value="{{ $selected_discount_allocation->id }}">
          <input type="hidden" name="invoice_date" value="{{ $invoice_date }}">
        
          <div class="col-md-12">
              <button class="float-right btn btn-success btn-flat btn-sm btn-block" type="button" onclick="return save_data()" style="font-weight: bold;">SAVE DATA</button>
          </div>
    </div>
   
   
  </form>
  </div>








@elseif($principal_name == 'DOLE')
<form action="post" class="save_form" id="save_form" name="save_form">
<p>{{ $branch }} <input type="hidden" name="branch" value="{{ $branch }}"></p>
   <div class="table table-responsive">
    
      <table class="table table-bordered table-hover">
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
          @foreach($sku_id as $data)
            @if($received_quantity[$data] != 0)
              
            <tr>
              <td>
                {{ $sku_code[$data] }}
                <input type="hidden" name="sku_id[]" value="{{ $data }}">
              </td>
              <td>{{ $description[$data] }}</td>
              <td>
                {{ $received_quantity[$data] }}
                <input type="hidden" name="quantity_per_sku[{{ $data }}]" value="{{ $received_quantity[$data] }}">
              </td>
              <td>{{ $unit_of_measurement[$data] }}</td>
              <td style="text-align: right;">
                {{ number_format($unit_cost[$data],2,".",",") }}
                <input type="hidden" name="unit_cost_per_sku[{{ $data }}]" value="{{ $unit_cost[$data] }}">
                <input type="hidden" name="price_1[{{ $data }}]" value="{{ $price_1[$data] }}">
                <input type="hidden" name="price_2[{{ $data }}]" value="{{ $price_2[$data] }}">
                <input type="hidden" name="price_3[{{ $data }}]" value="{{ $price_3[$data] }}">
                <input type="hidden" name="price_4[{{ $data }}]" value="{{ $price_4[$data] }}">
                <input type="hidden" name="category_id[{{ $data }}]" value="{{ $category_id[$data] }}">
                <input type="hidden" name="sku_type[{{ $data }}]" value="{{ $sku_type[$data] }}">
              </td>
              <td style="text-align: right;">
                @php
                  $vatable_purchase_per_sku = $unit_cost[$data] * $received_quantity[$data];
                  $sum_vatable_purchase_per_sku[] = $vatable_purchase_per_sku;
                @endphp
                {{ number_format($vatable_purchase_per_sku, 2, '.', ',') }}
              </td>
              <td style="text-align: right;">
                @php
                $discount_per_sku =  $vatable_purchase_per_sku * ($selected_discount_allocation->total_discount / 100);
                $sum_discount_per_sku[] = $discount_per_sku;
                @endphp
                {{ number_format($discount_per_sku, 2, '.', ',') }}
                <input type="hidden" name="discount_rate_per_sku[{{ $data }}]" value="{{ $selected_discount_allocation->total_discount }}">
              </td>
              <td style="text-align: right;">
                @php
                $bo_allowance_per_sku =  $vatable_purchase_per_sku * ($selected_discount_allocation->total_bo_allowance_discount / 100);
                $sum_bo_allowance_per_sku[] = $bo_allowance_per_sku;
                @endphp
                {{ number_format($bo_allowance_per_sku, 2, '.', ',') }}
                <input type="hidden" name="bo_allowance_discount_per_sku[{{ $data }}]" value="{{ $bo_allowance_per_sku }}">
                <input type="hidden" name="bo_allowance_discount_rate_per_sku[{{ $data }}]" value="{{ $selected_discount_allocation->total_bo_allowance_discount }}">
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
                <input type="hidden" name="final_total_cost_per_sku[{{ $data }}]" value="{{ $final_total_cost }}">
              </td>
              <td style="text-align: right;">
                @php
                  $final_unit_cost = $final_total_cost / $received_quantity[$data];
                  $sum_final_unit_cost[] = $final_unit_cost;
                @endphp
                {{ number_format($final_unit_cost,2,".",",") }}
                <input type="hidden" name="final_unit_cost_per_sku[{{ $data }}]" value="{{ $final_unit_cost }}">
              </td>
              <td style="text-align: center;">
                {{ $expiration_date[$data] }}
                <input type="hidden" name="expiration_date[{{ $data }}]" value="{{ $expiration_date[$data] }}">
              </td>
              <td style="text-align: center;">
                {{ $remarks[$data] }}
                <input type="hidde" name="remarks[{{ $data }}]" value="{{ $remarks[$data] }}">
              </td>
            </tr>
            @else

            @endif
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
      
           <table class="table table-bordered table-hover float-right" style="width:30%;">
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

     <div class="form-group">
          <input type="hidden" name="principal_id" value="{{ $principal_id }}">
          <input type="hidden" name="purchase_order_id" value="{{ $purchase_order_id }}">
          <input type="hidden" name="dr_si" value="{{ $dr_si }}">
          <input type="hidden" name="truck_number" value="{{ $truck_number }}">
          <input type="hidden" name="courier" value="{{ $courier }}">
          <input type="hidden" name="principal_name" value="{{ $principal_name }}">
          <input type="hidden" name="purchase_id" value="{{ $purchase_id }}">
          <input type="hidden" name="principal_discount_id" value="{{ $selected_discount_allocation->id }}">
          <input type="hidden" name="invoice_date" value="{{ $invoice_date }}">
          <button class="float-right btn btn-success btn-flat btn-sm btn-block" type="button" onclick="return save_data()" style="font-weight: bold;">SAVE DATA</button>
          </div>
      </div>
    </form>
  </div>










































































@else 
 
<form action="post" class="save_form" id="save_form" name="save_form">

  <div class="table table-responsive">
    <p>{{ $branch }} <input type="hidden" name="branch" value="{{ $branch }}"></p>
    <table class="table table-bordered table-hover" style="font-size:14px;">
      <thead>
        <tr>
          <th style="text-align: center;" colspan="{{ $selected_discount_counter + 1 }}">SELECTED DISCOUNT ALLOCATION</th>
        </tr>
        <tr>
          @foreach($selected_discount_rate as $selected_discount_rate_data)
          <th style="text-align: center;text-transform: uppercase;">{{ $selected_discount_rate_data->discount_name }}</th>
          @endforeach
          <th style="text-align: center;">BO ALLOWANCE DISCOUNT</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          @foreach($selected_discount_rate as $selected_discount_rate_data)
          <td style="text-align: center;text-transform: uppercase;">{{ $selected_discount_rate_data->discount_rate ."%" }}</td>
          @endforeach
          <td style="text-align: center;">{{ $selected_discount_allocation->total_bo_allowance_discount ."%"}}</td>
        </tr>
      </tbody>
    </table>
  
    <table class="table table-bordered table-hover" style="font-size:15px;">
      <thead>
        <tr>
          <th style="text-align: center;">CODE</th>
          <th style="text-align: center;">DESC</th>
          <th style="text-align: center;">QTY<br />RCVD</th>
          <th style="text-align: center;">UOM</th>
          <th style="text-align: center;">U/C</th>
          <th style="text-align: center;">TOTAL AMOUNT <br /> <i>VAT INCLUSIVE</i></th>.
          <th style="text-align: center;">VATABLE <br /> <i>PURCHASE</i></th>
          <th style="text-align: center;">DISCOUNT</th>
          <th style="text-align: center;">BO<br />ALLOWANCE</th>
          <th style="text-align: center;">VAT <br /> <i>AMOUNT</i></th>
          <th style="text-align: center;">FINAL TOTAL <br />COST</th>
          <th style="text-align: center;">FINAL UNIT <br />COST</th>  
          <th style="text-align: center;">REMARKS</th>
          <th style="text-align: center;">EXP <br />DATE</th> 
        </tr>
      </thead>
      <tbody>
        @foreach ($sku_id as $data)
          @if($received_quantity[$data] != 0)
            <tr>
              <td>
                {{ $sku_code[$data] }}
                <input type="hidden" name="sku_id[]" value="{{ $data }}">
              </td>
              <td>{{ $description[$data] }}</td>
              <td>
                {{ $received_quantity[$data] }}
                <input type="hidden" name="quantity_per_sku[{{ $data }}]" value="{{ $received_quantity[$data] }}">
              </td>
              <td>{{ $unit_of_measurement[$data] }}</td>
              <td style="text-align: right;">
                {{ number_format($unit_cost[$data],2,".",",") }}
                <input type="hidden" name="unit_cost_per_sku[{{ $data }}]" value="{{ $unit_cost[$data] }}">
                <input type="hidden" name="price_1[{{ $data }}]" value="{{ $price_1[$data] }}">
                <input type="hidden" name="price_2[{{ $data }}]" value="{{ $price_2[$data] }}">
                <input type="hidden" name="price_3[{{ $data }}]" value="{{ $price_3[$data] }}">
                <input type="hidden" name="price_4[{{ $data }}]" value="{{ $price_4[$data] }}">
                <input type="hidden" name="category_id[{{ $data }}]" value="{{ $category_id[$data] }}">
                <input type="hidden" name="sku_type[{{ $data }}]" value="{{ $sku_type[$data] }}">
              </td>
              <td style="text-align: right;">
                @php
                $total_amount = $unit_cost[$data]* $received_quantity[$data];
                $sum_total_amount[] = $total_amount;
                @endphp
                {{ number_format($unit_cost[$data]* $received_quantity[$data],2,".",",") }}
              </td>
              <td style="text-align: right;">
                @php
                $vatable_purchase_up = $total_amount / 1.12;
                $sum_vatable_purchase_up[] = $vatable_purchase_up;
                @endphp
                {{ number_format($vatable_purchase_up,2,".",",") }}
              </td>
              
              <td style="text-align: right;">
                @php
                $discounted_unit_cost = ($vatable_purchase_up*($selected_discount_allocation->total_discount/100));
                $sum_discounted_unit_cost[] = $discounted_unit_cost;
                @endphp
                {{ number_format($discounted_unit_cost,2,".",",") }}
                <input type="hidden" name="discount_rate_per_sku[{{ $data }}]" value="{{ $selected_discount_allocation->total_discount }}">
              </td>
              <td style="text-align: right;">
                @php
                $bo_allowance_unit_cost = ($vatable_purchase_up*($selected_discount_allocation->total_bo_allowance_discount/100));
                $sum_bo_allowance_unit_cost[] = $bo_allowance_unit_cost;
                @endphp
                {{ number_format($bo_allowance_unit_cost,2,".",",") }}
                <input type="hidden" name="bo_allowance_discount_per_sku[{{ $data }}]" value="{{ $bo_allowance_unit_cost }}">
                <input type="hidden" name="bo_allowance_discount_rate_per_sku[{{ $data }}]" value="{{ $selected_discount_allocation->total_bo_allowance_discount }}">
              </td>
              <td style="text-align: right;">
                @php
                $vat_amount_up = ($vatable_purchase_up - $discounted_unit_cost - $bo_allowance_unit_cost)*.12;
                $sum_vat_amount_up[] = $vat_amount_up;
                @endphp
                {{ number_format($vat_amount_up,2,".",",") }}
              </td>
              <td style="text-align: right;">
                @php
                $final_total_cost = $vatable_purchase_up - $discounted_unit_cost - $bo_allowance_unit_cost + $vat_amount_up;
                $sum_final_total_cost[] = $final_total_cost;
                @endphp
                {{ number_format($final_total_cost,2,".",",") }}
                <input type="hidden" name="final_total_cost_per_sku[{{ $data }}]" value="{{ $final_total_cost }}">
              </td>
              <td style="text-align: right;">
                @php
                $final_unit_cost = $final_total_cost / $received_quantity[$data];
                $sum_final_unit_cost[] = $final_unit_cost;
                @endphp
                {{ number_format($final_unit_cost,2,".",",") }}
                <input type="hidden" name="final_unit_cost_per_sku[{{ $data }}]" value="{{ $final_unit_cost }}">
               
              </td>
              
              <td style="text-align: center;">
                  {{ $remarks[$data] }}
                  <input type="hidden" name="remarks[{{ $data }}]" value="{{ $remarks[$data] }}">
              </td>
              <td style="text-align: right">
                  {{ $expiration_date[$data] }}
                  <input type="hidden" name="expiration_date[{{ $data }}]" value="{{ $expiration_date[$data] }}">
                </td>
            </tr>
          @else

          @endif
        @endforeach
        <tr>
          <td colspan="5" style="font-weight: bold;text-align: center;">GRAND TOTAL</td>
          <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_total_amount),2,".",",") }}</td>
          <td style="text-align: right;font-weight: bold;">
            {{ number_format(array_sum($sum_vatable_purchase_up),2,".",",") }}
            <input type="hidden" name="total_vatable_purchase" value="{{ array_sum($sum_vatable_purchase_up) }}">
          </td>
          <td style="text-align: right;font-weight: bold;">
            {{ number_format(array_sum($sum_discounted_unit_cost),2,".",",") }}
            <input type="hidden" name="total_discount" value="{{ array_sum($sum_discounted_unit_cost) }}">
          </td>
          <td style="text-align: right;font-weight: bold;">
            {{ number_format(array_sum($sum_bo_allowance_unit_cost),2,".",",") }}
            <input type="hidden" name="total_bo_allowance_discount" value="{{ array_sum($sum_bo_allowance_unit_cost) }}">
          </td>
          <td style="text-align: right;font-weight: bold;">
            {{ number_format(array_sum($sum_vat_amount_up),2,".",",") }}
            <input type="hidden" name="total_vat_amount" value="{{ array_sum($sum_vat_amount_up) }}">
          </td>
          <td style="text-align: right;font-weight: bold;">
            {{ number_format(array_sum($sum_final_total_cost),2,".",",") }}
            <input type="hidden" name="grand_total_final_cost" value="{{ array_sum($sum_final_total_cost) }}">
          </td>
          <td colspan="3"></td>
        </tr>

      </tbody>
    </table>





    <table class="table table-bordered table-hover float-right" style="width:30%;">
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
          {{  number_format($vatable_purchase,2,".",",") }}
          
        </td >
      </tr>
      <tr>
        <td style="text-align: left;width:50%;">LESS: DISCOUNTS</td>
        <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
          @php
          $less_discount = array_sum($sum_discounted_unit_cost) + array_sum($sum_bo_allowance_unit_cost);
          @endphp
          {{  number_format($less_discount*-1,2,".",",") }}
          
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
          
        </td>
      </tr>
      <tr>
        <td style="font-weight: bold;">FINAL TOTAL COST</td>
        <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
          @php
          $grand_final_total_cost = $net_discount + $vat_amount;
          @endphp
          {{  number_format($grand_final_total_cost,2,".",",") }}
          
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
    <div class="form-group">
        <input type="hidden" name="principal_id" value="{{ $principal_id }}">
        <input type="hidden" name="purchase_order_id" value="{{ $purchase_order_id }}">
        <input type="hidden" name="dr_si" value="{{ $dr_si }}">
        <input type="hidden" name="truck_number" value="{{ $truck_number }}">
        <input type="hidden" name="courier" value="{{ $courier }}">
        <input type="hidden" name="principal_name" value="{{ $principal_name }}">
        <input type="hidden" name="purchase_id" value="{{ $purchase_id }}">
        <input type="hidden" name="principal_discount_id" value="{{ $selected_discount_allocation->id }}">
        <input type="hidden" name="invoice_date" value="{{ $invoice_date }}">
      <div class="col-md-12">
        <button class="float-right btn btn-success btn-flat btn-sm btn-block" type="button" onclick="return save_data()" style="font-weight: bold;">SAVE DATA</button>
      </div>
    </div>
  </form>
</div>

























































































































































@endif





<script>  
 function save_data() {
      var form = document.save_form;
      var dataString = $(form).serialize();
      $('.loading').show();
          $.ajax({
              type:'POST',
              url:'/received_order_save',
              data: dataString,
              success: function(data){
                
                console.log(data);
                if(data == 'Saved'){
                toastr.success('RECEIVED ORDER DATA SAVED! RELOADING PAGE PLEASE WAIT.')
                setTimeout(function(){
                        location.reload();
                  }, 2000);
                
                }else{
                  toastr.error('Something went wrong, please redo process');
                }                
              }
          });
          return false;
      }
</script>