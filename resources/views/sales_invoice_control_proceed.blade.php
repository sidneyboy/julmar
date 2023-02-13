<form action="{{ route('sales_control_proceed_to_print_dr') }}" method="get" target="_blank">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <td colspan="8" style="font-weight: bold;text-align: center;">SALESMAN CONTROL LIST OF CUSTOMER</td>
            </tr>
            <tr>
                <th style="text-align: center;">DR NO</th>
                <th style="text-align: center;">CUSTOMER</th>
                <th style="text-align: center;">MOT</th>
                <th style="text-align: center;">AMOUNT</th>
                <th style="text-align: center;">CUSTOMER DISCOUNT</th>
                <th style="text-align: center;">NET AMOUNT</th>
                <th style="text-align: center;">DRIVER</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales_invoices as $data)
                <tr>
                    <td>
                        <input type="hidden" name="so_id[]" value="{{ $data->id }}">
                        <input type="hidden" name="so_dr[{{ $data->id }}]" value="{{ $data->delivery_receipt }}">
                        {{ $data->delivery_receipt }}
                    </td>
                    <td>
                        {{ $data->customer->store_name }}
                        <input type="hidden" name="so_store_name[{{ $data->id }}]"
                            value="{{ $data->customer->store_name }}">
                    </td>
                    <td>
                        {{ $data->mode_of_transaction }}
                        <input type="hidden" name="so_mode_of_transaction[{{ $data->id }}]"
                            value="{{ $data->mode_of_transaction }}">
                    </td>
                    <td style="text-align: right;">
                        {{ number_format($data->total, 2, '.', ',') }}
                        @php
                            $sum_customer_total_amount[] = $data->total;
                        @endphp
                        {{-- <input type="hidden" name="so_amount[{{ $data->id }}]"
                            value="{{ $print->total_amount + $print->total_line_discount + $print->total_customer_discount }}"> --}}

                    </td>
                    <td style="text-align: right">{{ $data->customer_discount }}</td>
                    <td style="text-align: right">
                        @php
                            $total_net_amount = $data->total - $data->customer_discount;
                            $sum_total_net_amount[] = $total_net_amount;
                            $sum_total_customer_discount[] = $data->customer_discount;
                            echo number_format($total_net_amount, 2, '.', ',');
                        @endphp
                    </td>
                    <td></td>
                </tr>
            @endforeach
            <tr>
                <th colspan="3" style="text-align: center;font-weight: bold">SALESMAN CONTROL GRANDTOTAL</th>
                <th style="text-align: right;font-weight: bold">
                    {{ number_format(array_sum($sum_customer_total_amount), 2, '.', ',') }}
                </th>
                <th style="text-align: right;font-weight: bold">
                    {{ number_format(array_sum($sum_total_customer_discount), 2, '.', ',') }}
                </th>
                <th style="text-align: right;font-weight: bold">
                    {{ number_format(array_sum($sum_total_net_amount), 2, '.', ',') }}
                </th>
                <th></th>
                {{-- <th style="text-align: right"> {{ number_format(array_sum($total_net_amount), 2, '.', ',') }}</th> --}}
                {{-- <td style="text-align: right;font-weight: bold">
                    {{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}
                    <input type="hidden" name="so_sum_total_amount" value="{{ array_sum($sum_total_amount) }}">
                </td> --}}
            </tr>
        </tbody>
    </table>











    <table class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th colspan="7" style="text-align: center;">SKU CONTROL FROM ALL CUSTOMERS</th>
            </tr>
            <tr>
                <th>SKU</th>
                <th>DESCRIPTION</th>
                <th>SKU TYPE</th>
                <th>QUANTITY</th>
                <th>AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $data)
                <tr>
                    <td>
                        <input type="hidden" name="sku_id[]" value="{{ $data->sku_id }}">
                        <input type="hidden" name="sku_code[{{ $data->sku_id }}]" value="{{ $data->sku->sku_code }}">
                        {{ $data->sku->sku_code }}
                    </td>
                    <td>
                        <input type="hidden" name="description[{{ $data->sku_id }}]"
                            value="{{ $data->sku->description }}">
                        {{ $data->sku->description }}
                    </td>
                    <td>
                        <input type="hidden" name="sku_type[{{ $data->sku_id }}]" value="{{ $data->sku->sku_type }}">
                        {{ $data->sku->sku_type }}
                    </td>
                    <td style="text-align:right;">
                        <input type="hidden" name="quantity[{{ $data->sku_id }}]"
                            value="{{ $quantity[$data->sku_id] }}">
                        {{ $quantity[$data->sku_id] }}
                    </td>
                    <td style="text-align:right;">
                        @php
                            $sum_amount[] = $amount[$data->sku_id];
                            $total_quantity[] = $quantity[$data->sku_id];
                        @endphp
                        {{ number_format($amount[$data->sku_id], 2, '.', ',') }}
                        <input type="hidden" name="amount[{{ $data->sku_id }}]" value="{{ $amount[$data->sku_id] }}">
                    </td>
                    {{-- <td style="text-align:right;">
					@php
					$sum_sub_total[] = $sub_total[$data->sku_id];
					@endphp
					{{ number_format($sub_total[$data->sku_id],2,".",",")  }}
					<input type="hidden" name="sub_total[{{ $data->sku_id }}]" value="{{ $sub_total[$data->sku_id] }}">
				</td> --}}
                </tr>
            @endforeach
            <tr>
                <td colspan="2"></td>
                <th style="text-align:right">Customer Discount </th>
                <td style="text-align: right;font-weight: bold">
                    {{ number_format(array_sum($sum_total_customer_discount), 2, '.', ',') }}

                </td>
                <td style="text-align: right;font-weight: bold">
                    {{ number_format(array_sum($sum_amount), 2, '.', ',') }}
                    <input type="hidden" name="sum_amount" value="{{ array_sum($sum_amount) }}">
                </td>

            </tr>
            <tr>
                <td colspan="2"></td>
                <th style="text-align:right">Net Amount</th>

                <td style="text-align: right;font-weight: bold" colspan="2">
                    @php
                        $sku_final_amount = array_sum($sum_amount) - array_sum($sum_total_customer_discount);
                        
                    @endphp
                    {{ number_format($sku_final_amount, 2, '.', ',') }}
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <th style="text-align:right">Sum Qty </th>
                <td style="text-align: right;font-weight: bold">
                    {{ array_sum($total_quantity) }}
                    <input type="hidden" name="total_quantity" value="{{ array_sum($total_quantity) }}">
                </td>
            </tr>

        </tbody>
    </table>



    {{-- <div class="row">
		<div class="col-md-12">
			<label>&nbsp;</label>
			<button type="submit" class="btn btn-success btn-block" target="_blank"><span class="fas fa-print"></span> PRINT DR AND SALESMAN CONTROL</button>
		</div>
	</div> --}}
</form>
