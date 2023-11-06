<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm table-striped">
        <thead>
            <tr>
                <td>Verified By:</td>
                <th style="text-align: center;">
                    @if ($cm_data->verified_by != null)
                        {{ $cm_data->verified_by }}
                    @else
                        {{ $cm_data->verified_by_name }}
                    @endif
                </th>
                <td>Verified Date:</td>
                <th style="text-align: center;">{{ $cm_data->verified_date }}</th>
                <td>Returned By:</td>
                <th style="text-align: center;">{{ $cm_data->returned_by }}</th>
                <td>PCM Number:</td>
                <th style="text-align: center;">{{ $cm_data->pcm_number }}</th>
                <td>Amount:</td>
                <th style="text-align: center;">{{ number_format($cm_data->total_amount, 2, '.', ',') }}</th>
            </tr>
            <tr>
                <td>PCM Type:</td>
                <th style="text-align: center;">
                    @if ($transaction == 'RGS')
                        Return Good Stock
                    @elseif($transaction == 'BO')
                        Bad Order
                    @endif
                </th>
                <td>Customer:</td>
                <th style="text-align: center;">{{ $cm_data->customer->store_name }}
                </th>
                <td>Principal:</td>
                <th style="text-align: center;">{{ $cm_data->principal->principal }}
                </th>
                <td>Delivery Receipt:</td>
                <th style="text-align: center;">
                    @if ($cm_data->si_id != null)
                        {{ $cm_data->sales_invoice->delivery_receipt }}
                    @else
                        {{ $cm_data->delivery_receipt }}
                    @endif
                </th>
                <td>Sku Type:</td>
                <th style="text-align: center;">{{ $cm_data->sku_type }}</th>
            </tr>
        </thead>
    </table>
</div>

<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm table-striped">
        <thead>
            <tr>
                <th style="text-align: center;">Code</th>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: center;">Unit Price</th>
                <th style="text-align: center;">Sub-Total</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @if ($transaction == 'RGS')
                @foreach ($cm_data->return_good_stock_details as $details)
                    <tr>
                        <td>{{ $details->sku->sku_code }}</td>
                        <td>{{ $details->sku->description }}</td>
                        <td style="text-align: right">{{ $details->confirmed_quantity }}</td>
                        <td style="text-align: right">{{ number_format($details->unit_price, 2, '.', ',') }}</td>
                        <td style="text-align: right">
                            @php
                                $sub_total = $details->confirmed_quantity * $details->unit_price;
                                $sum_total[] = $sub_total;
                                $sum_quantity[] = $details->confirmed_quantity;
                                echo number_format($sub_total, 2, '.', ',');
                            @endphp
                        </td>
                        <td>
                            @if ($details->remarks != 'scanned')
                                {{ $details->remarks }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th style="text-align: right">{{ array_sum($sum_quantity) }}</th>
                <th></th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
