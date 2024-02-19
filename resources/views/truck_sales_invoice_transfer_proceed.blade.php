<div class="table table-responsive">
    <table class="table table-bordered table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6">DELIVERY RECEIPT: {{ $sales_invoice->delivery_receipt }}</th>
            </tr>
            <tr>
                <th class="text-center">CODE</th>
                <th class="text-center">DESCRIPTION</th>
                <th class="text-center">QUANTITY</th>
                <th class="text-center">U/P</th>
                <th class="text-center">DISCOUNT</th>
                <th class="text-center">SUB-TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales_invoice->sales_invoice_details as $details)
                <tr>
                    <td>{{ $details->sku->sku_code }}</td>
                    <td>{{ $details->sku->description }}</td>
                    <td style="text-align: right">{{ $details->quantity }}
                        @php
                            $total_quantity[] = $details->quantity;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($details->unit_price, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($details->total_discount_per_sku, 2, '.', ',') }}
                    </td>
                    <td style="text-align: right">
                        {{ number_format($details->total_amount_per_sku, 2, '.', ',') }}
                        @php
                            $total_sum[] = $details->total_amount_per_sku;
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: right">{{ array_sum($total_quantity) }}</td>
                <td></td>
                <td></td>
                <td style="text-align: right">{{ number_format(array_sum($total_sum), 2, '.', ',') }}</td>
            </tr>
        </tfoot>
    </table>
</div>

<form id="truck_sales_invoice_transfer_save">
    @csrf
    <input type="text" name="sales_invoice_id" value="{{ $sales_invoice->id }}">
    <button class="btn btn-sm float-right btn-success" type="submit">Transfer</button>
</form>

<script>
    $("#truck_sales_invoice_transfer_save").on('submit', (function(e) {
        e.preventDefault();
        // $('#loader').show();
        $.ajax({
            url: "truck_sales_invoice_transfer_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                });

                location.reload();
                s
            },
            error: function(error) {
                $('#loader').hide();
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));
</script>
