<form class="myform" id="myform" name="myform">
<table class="table table-bordered table-hover">
  <thead>
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
  </thead>
  <tbody>
    @foreach ($checkbox_entry as $data)
      <tr>
        <td style="text-align: center;text-transform: uppercase;">{{ $code[$data] }}</td>
        <td style="text-align: center;text-transform: uppercase;">{{ $description[$data] }}</td>
        <td style="text-align: center;text-transform: uppercase;">{{ $unit_of_measurement[$data] }}</td>
        <td style="text-align: center">{{ $quantity_return_per_sku[$data] }}</td>
        <td style="text-align: right">{{ number_format($unit_cost[$data],2,".",",")  }}</td>
        <td style="text-align: right">
          @php
            $total_amount = $unit_cost[$data] * $quantity_return_per_sku[$data];
            $sum_total_amount[] = $total_amount;
          @endphp
          {{ number_format($total_amount,2,".",",") }}
        </td>
        <td style="text-align: right">
          @php
            // $total_amount = $unit_cost[$data] * $quantity_return_per_sku[$data];
            // $sum_total_amount[] = $total_amount;
            $vatable_purchase = $total_amount/1.12;
            $sum_vatable_purchase[] = $vatable_purchase;
          @endphp
          {{ number_format($vatable_purchase,2,".",",") }}
        </td>
         <td style="text-align: right">
          @php
            // $total_amount = $unit_cost[$data] * $quantity_return_per_sku[$data];
            // $sum_total_amount[] = $total_amount;
            $discount = $vatable_purchase*$principal_discount->total_discount/100;
            $sum_discount[] = $discount;
          @endphp
          {{ number_format($discount,2,".",",") }}
        </td>
         <td style="text-align: right">
          @php
            // $total_amount = $unit_cost[$data] * $quantity_return_per_sku[$data];
            // $sum_total_amount[] = $total_amount;
            $bo_allowance = $vatable_purchase*$principal_discount->total_bo_allowance_discount/100;
            $sum_bo_allowance[] = $bo_allowance;
          @endphp
          {{ number_format($bo_allowance,2,".",",") }}
        </td>
        <td style="text-align: right">
          @php
            // $total_amount = $unit_cost[$data] * $quantity_return_per_sku[$data];
            // $sum_total_amount[] = $total_amount;
            $vat = ($vatable_purchase - $discount - $bo_allowance) *0.12;
            $sum_vat[] = $vat;
          @endphp
          {{ number_format($vat,2,".",",") }}
        </td>
        <td style="text-align: right">
          @php
            // $total_amount = $unit_cost[$data] * $quantity_return_per_sku[$data];
            // $sum_total_amount[] = $total_amount;
            $final_total_cost = $vatable_purchase - $discount - $bo_allowance + $vat;
            $sum_final_total_cost[] = $final_total_cost;
          @endphp
          {{ number_format($final_total_cost,2,".",",") }}
        </td>
        <td style="text-align: right">
          @php
            // $total_amount = $unit_cost[$data] * $quantity_return_per_sku[$data];
            // $sum_total_amount[] = $total_amount;
            $final_unit_cost = $final_total_cost/ $quantity_return_per_sku[$data];
            $sum_final_unit_cost[] = $final_unit_cost;
          @endphp
          <input type="hidden" name="final_unit_cost[{{ $data }}]" value="{{ $final_unit_cost }}">
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
             {{--  <td style="font-weight: bold;text-align: right;">{{ number_format(array_sum($sum_total_amount),2,".",",") }}</td> --}}
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
    <input type="hidden" name="return_discount_id" value="{{ $return_discount_id }}">
</form>

<div class="row">
    <div class="col-md-12">
      <button class="btn btn-success btn-block " style="border-radius: 0px;" type="button" onclick="return save()">SAVE ACTIVITY</button>
    </div>
</div>


<script>
  function save() {
    
    var form = document.myform;
    var dataString = $(form).serialize();
      //$('.loading').show();
        $.ajax({
            type:'POST',
            url:'/return_to_principal_save',
            data: dataString,
            success: function(data){
              
              
              if(data == 'Saved'){
                toastr.success('RETURN SKU SAVED! RELOADING PAGE PLEASE WAIT.')
                $('.loading').show();
                setTimeout(function(){
                  location.reload();
                }, 100);
                
              }else{
                toastr.error('Something went wrong, please redo process');
                $('.loading').hide();
              }
             
            }
        });
        return false;
    }
  </script>