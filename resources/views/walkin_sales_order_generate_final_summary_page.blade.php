<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm">
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>U/P</th>
                <th>Amount</th>
                @if (array_sum($line_discount_rate_1) != 0)
                    <th style="text-align: center;">Disc</th>
                @endif
                @if (array_sum($line_discount_rate_2) != 0)
                    <th style="text-align: center;">Disc</th>
                @endif
                <th style="text-align: center;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sku as $data)
                <tr>
                    <td>{{ $sku_code[$data] }} - {{ $description[$data] }}</td>
                    <td style="text-align: right">
                        @php
                            $sum_quantity[] = $quantity[$data];
                            echo $quantity[$data];
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($unit_price[$data], 2, '.', ',')  }}</td>
                    <td style="text-align: right">
                        @php
                            $amount = $quantity[$data] * $unit_price[$data];
                            $sum_amount[] = $amount;
                            echo number_format($amount, 2, '.', ',');
                        @endphp
                    </td>
                    @if (array_sum($line_discount_rate_1) != 0)
                        <td style="text-align: right;">
                            @php
                                $line_discount_1 = ($amount * $line_discount_rate_1[$data]) / 100;
                                $sum_line_discount_1[] = $line_discount_1;
                                echo number_format($line_discount_1, 2, '.', ',');
                            @endphp
                        </td>
                    @else
                        @php
                            $line_discount_1 = 0;
                            $sum_line_discount_1[] = $line_discount_1;
                        @endphp
                    @endif

                    @if (array_sum($line_discount_rate_2) != 0)
                        <td style="text-align: right;">
                            @php
                                $line_discount_2 = (($amount - $line_discount_1) * $line_discount_rate_2[$data]) / 100;
                                $sum_line_discount_2[] = $line_discount_2;
                                echo number_format($line_discount_2, 2, '.', ',');
                            @endphp
                        </td>
                    @else
                        @php
                            $line_discount_2 = 0;
                            $sum_line_discount_2[] = $line_discount_2;
                        @endphp
                    @endif
                    <td style="text-align: right">
                        @php
                            $total_amount_per_sku = $amount - $line_discount_1 - $line_discount_2;
                            $sum_total_amount_per_sku[] = $total_amount_per_sku;
                            echo number_format($total_amount_per_sku, 2, '.', ',');
                        @endphp
                    </td>
                </tr>
            @endforeach
            <tr>
                <td style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                <td style="text-align: center;font-weight: bold">{{ array_sum($sum_quantity) }}</td>
                <td></td>
                <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_amount), 2, '.', ',') }}
                </td>
                @if (array_sum($line_discount_rate_1) != 0)
                    <td style="text-align: right;font-weight: bold">
                        {{ number_format(array_sum($sum_line_discount_1), 2, '.', ',') }}</td>
                @endif
                @if (array_sum($line_discount_rate_2) != 0)
                    <td style="text-align: right;font-weight: bold">
                        {{ number_format(array_sum($sum_line_discount_2), 2, '.', ',') }}</td>
                @endif
                <td style="text-align: right;font-weight: bold">
                    {{ number_format(array_sum($sum_total_amount_per_sku), 2, '.', ',') }}</td>
            </tr>
        </tbody>
    </table>
</div>
