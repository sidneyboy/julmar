<form action="{{ route('sales_invoice_control_print') }}" method="post" target="_blank">
    @csrf
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-striped table-hover">
            <thead>
                <tr>
                    <th colspan="8">1ST CONTROL</th>
                </tr>
                <tr>
                    <th colspan="8">{{ $sales_invoice[0]->sales_invoice_control_agent->full_name }}</th>
                </tr>
                <tr>
                    <th style="text-align: center;">DATE</th>
                    <th style="text-align: center;">DR</th>
                    <th style="text-align: center;">CUSTOMER</th>
                    <th style="text-align: center;">TRANSACTION</th>
                    <th style="text-align: center;">AMOUNT</th>
                    <th style="text-align: center;">DISCOUNT</th>
                    <th style="text-align: center;">NET AMOUNT</th>
                    <th style="text-align: center;">DRIVER</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_invoice as $data)
                    <tr>
                        <td>{{ $data->sales_invoice_printed }}</td>
                        <td style="text-transform:uppercase">{{ $data->delivery_receipt }}</td>
                        <td>{{ $data->sales_invoice_control_customer->store_name }}</td>
                        <td>{{ $data->mode_of_transaction }}</td>
                        <td style="text-align: right;">
                            {{ number_format($data->total + $data->customer_discount, 2, '.', ',') }}
                            @php
                                $total_and_discount_1st_control[] = $data->total + $data->customer_discount;
                            @endphp
                        </td>
                        <td style="text-align: right;">{{ number_format($data->customer_discount, 2, '.', ',') }}
                            @php
                                $total_customer_discount_1st_control[] = $data->customer_discount;
                            @endphp
                        </td>
                        <td style="text-align: right;">{{ number_format($data->total, 2, '.', ',') }}
                            @php
                                $total_net_amount_1st_control[] = $data->total;
                            @endphp
                        </td>
                        <td>
                            <input type="hidden" name="sales_invoice_id[]" value="{{ $data->id }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="text-align: center;">TOTAL</th>
                    <th style="text-align: right">
                        {{ number_format(array_sum($total_and_discount_1st_control), 2, '.', ',') }}</th>
                    <th style="text-align: right">
                        {{ number_format(array_sum($total_customer_discount_1st_control), 2, '.', ',') }}</th>
                    <th style="text-align: right">
                        {{ number_format(array_sum($total_net_amount_1st_control), 2, '.', ',') }}
                    </th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-striped table-hover">
            <thead>
                <tr>
                    <th colspan="8">2ND CONTROL</th>
                </tr>
                <tr>
                    <th colspan="8">{{ $sales_invoice[0]->sales_invoice_control_agent->full_name }}</th>
                </tr>
                <tr>
                    <th style="text-align: center;">CODE</th>
                    <th style="text-align: center;">DESCRIPTION</th>
                    <th style="text-align: center;">UOM</th>
                    <th style="text-align: center;">QTY</th>
                    <th style="text-align: center;">NET AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_invoice_details as $data)
                    <tr>
                        <td>{{ $data->sales_invoice_control_sku->sku_code }}</td>
                        <td>{{ $data->sales_invoice_control_sku->description }}</td>
                        <td>{{ $data->sales_invoice_control_sku->unit_of_measurement }}</td>
                        <td style="text-align: right">{{ $data->total_quantity }}
                            @php
                                $total_quantity[] = $data->total_quantity;
                            @endphp
                        </td>
                        <td style="text-align: right;">{{ number_format($data->total_amount, 2, '.', ',') }}
                            @php
                                $total_amount_2nd_control[] = $data->total_amount;
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th style="text-align: center;">TOTAL</th>
                    <td style="text-align: right;">{{ array_sum($total_quantity) }}</td>
                    <td style="text-align: right;">
                        {{ number_format(array_sum($total_amount_2nd_control), 2, '.', ',') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <button class="btn btn-sm float-right btn-success" id="submit">Submit</button>
</form>

<script>
    $("#submit").click(function() {
        location.reload();
    });
</script>
