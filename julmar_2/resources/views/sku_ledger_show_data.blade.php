<div class="table table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th style="text-align: center;">CODE</th>
        <th style="text-align: center;">DESCRIPTION</th>
         <th style="text-align: center;">TYPE</th>
        <th style="text-align: center;">IN<br />OUT<br />ADJUSTMENTS</th>
        <th style="text-align: center;">RR<br />DR</th>
        <th style="text-align: center;">SALES<br />ORDER<br />NUMBER</th>
        <th style="text-align: center;">PRINCIPAL<br />INVOICE</th>
        <th style="text-align: center;">QUANTITY</th>
        <th style="text-align: center;">RUNNING<br />BALANCE</th>
        <th style="text-align: center;">UNIT<br />COST</th>
        <th style="text-align: center;">TOTAL<br />COST</th>
        <th style="text-align: center;">ADJUST<br />MENTS</th>
        <th style="text-align: center;">RUNNING<br />TOTAL<br />COST</th>
        <th style="text-align: center;">FINAL<br />UNIT<br />COST</th>
        <th style="text-align: center;">TRANSACTION<br />DATE</th>
      </tr>
    </thead>
    <tbody>
    @if($search_method == 'principal')
      @if($counter != 0)
        @for ($i=0; $i < $counter; $i++)
          <tr>
            <td style="text-align: center;text-transform: uppercase;"><a href="{{ route('sku_ledger_show_sku_details', $select_ledger_sku[$i]->sku_id ."=". $date_from ."=". $date_to) }}" target="_blank">{{ $select_ledger_sku[$i]->sku->sku_code }}</a></td>
            <td style="text-align: center;text-transform: uppercase;">{{ $select_ledger_sku[$i]->sku->description }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $select_ledger_sku[$i]->sku->sku_type }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $in_out_adjustments[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $rr_dr[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $sales_order_number[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $principal_invoice[$i] }}</td>
            <td style="text-align: center;">{{ $quantity[$i] }}</td>
            <td style="text-align: center;">{{ $running_balance[$i] }}</td>
            <td style="text-align: right;">{{ number_format($unit_cost[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format($total_cost[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format( $adjustments[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format($running_total_cost[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format($final_unit_cost[$i],2,".",",") }}</td>
            <td style="text-align: center;">{{ $transaction_date[$i] }}</td>
          </tr>
        @endfor
      @else
        <tr>
          <td colspan="15" style="text-align: center;font-weight: bold;color:red;">NO DATA FOUND</td>
        </tr>
      @endif
    @elseif($search_method == 'sku_code')
      @if($counter != 0)
        @for ($i=0; $i < $counter; $i++)
          <tr>
            <td style="text-align: center;text-transform: uppercase;"><a href="{{ route('sku_ledger_show_sku_details', $search_sku[$i]->id ."=". $date_from ."=". $date_to) }}" target="_blank">{{ $search_sku[$i]->sku_code }}</a></td>
            <td style="text-align: center;text-transform: uppercase;">{{ $search_sku[$i]->description }}</td>
             <td style="text-align: center;text-transform: uppercase;">{{ $search_sku[$i]->sku_type }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $in_out_adjustments[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $rr_dr[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $sales_order_number[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $principal_invoice[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $quantity[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $running_balance[$i] }}</td>
            <td style="text-align: right;">{{ number_format($unit_cost[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format($total_cost[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format( $adjustments[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format($running_total_cost[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format($final_unit_cost[$i],2,".",",") }}</td>
            <td style="text-align: center;">{{ $transaction_date[$i] }}</td>
          </tr>
        @endfor
      @else
        <tr>
          <td colspan="15" style="text-align: center;font-weight: bold;color:red;">NO DATA FOUND</td>
        </tr>
      @endif
      
    @elseif($search_method == 'type')
       @if($counter != 0)
        @for ($i=0; $i < $counter; $i++)
          <tr>
            <td style="text-align: center;text-transform: uppercase;"><a href="{{ route('sku_ledger_show_sku_details', $select_ledger_sku[$i]->sku_id ."=". $date_from ."=". $date_to) }}" target="_blank">{{ $select_ledger_sku[$i]->sku->sku_code }}</a></td>
            <td style="text-align: center;text-transform: uppercase;">{{ $select_ledger_sku[$i]->sku->description }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $in_out_adjustments[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $rr_dr[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $sales_order_number[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $principal_invoice[$i] }}</td>
            <td style="text-align: center;">{{ $quantity[$i] }}</td>
            <td style="text-align: center;">{{ $running_balance[$i] }}</td>
            <td style="text-align: right;">{{ number_format($unit_cost[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format($total_cost[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format( $adjustments[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format($running_total_cost[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format($final_unit_cost[$i],2,".",",") }}</td>
            <td style="text-align: center;">{{ $transaction_date[$i] }}</td>
          </tr>
        @endfor
      @else
        <tr>
          <td colspan="15" style="text-align: center;font-weight: bold;color:red;">NO DATA FOUND</td>
        </tr>
      @endif
     @elseif($search_method == 'category')
      @if($counter != 0)
        @for ($i=0; $i < $counter; $i++)
          <tr>
            <td style="text-align: center;text-transform: uppercase;"><a href="{{ route('sku_ledger_show_sku_details', $select_ledger_sku[$i]->sku_id ."=". $date_from ."=". $date_to) }}" target="_blank">{{ $select_ledger_sku[$i]->sku->sku_code }}</a></td>
            <td style="text-align: center;text-transform: uppercase;">{{ $select_ledger_sku[$i]->sku->description }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $select_ledger_sku[$i]->sku->sku_type }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $in_out_adjustments[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $rr_dr[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $sales_order_number[$i] }}</td>
            <td style="text-align: center;text-transform: uppercase;">{{ $principal_invoice[$i] }}</td>
            <td style="text-align: center;">{{ $quantity[$i] }}</td>
            <td style="text-align: center;">{{ $running_balance[$i] }}</td>
            <td style="text-align: right;">{{ number_format($unit_cost[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format($total_cost[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format( $adjustments[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format($running_total_cost[$i],2,".",",") }}</td>
            <td style="text-align: right;">{{ number_format($final_unit_cost[$i],2,".",",") }}</td>
            <td style="text-align: center;">{{ $transaction_date[$i] }}</td>
          </tr>
        @endfor
      @else
        <tr>
          <td colspan="15" style="text-align: center;font-weight: bold;color:red;">NO DATA FOUND</td>
        </tr>
      @endif
     @endif
    </tbody>
  </table>
  
</div>