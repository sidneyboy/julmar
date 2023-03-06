<form id="warehouse_saved">
    <div class="table table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th colspan="5">ORIGINAL INVOICE DATA</th>
                </tr>
                <tr>
                    <th>
                        {{ $invoice[0]->customer }}
                    </th>
                    <th>
                        {{ $invoice[0]->delivery_receipt }}
                    </th>
                    <th>
                        {{ strtoupper($invoice[0]->sales_representative) }}
                    </th>
                    <th colspan="2">
                        {{ strtoupper($invoice[0]->principal) }}
                    </th>
                </tr>
                <tr>
                    <th>Code</th>
                    <th>Desc</th>
                    <th>Sku Type</th>
                    <th>Quantity</th>
                    <th>Available Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice as $data)
                    @if ($final_quantity[$data->id] == 0)
                        <tr style="background:red;">
                            <td>{{ $data->sku_code }}</td>
                            <td>{{ $data->description }}</td>
                            <td>{{ $data->sku_type }}</td>
                            <td style="text-align: right">
                                {{ $data->quantity }}
                                @php
                                    $quantity_sum[] = $data->quantity;
                                @endphp
                            </td>
                            <td style="text-align: right">{{ $final_quantity[$data->id] }}
                                @php
                                    $final_quantity_sum[] = $final_quantity[$data->id];
                                @endphp
                                <input type="hidden" name="id[]" value="{{ $data->id }}">
                                <input type="hidden" name="sku_type[{{ $data->id }}]" value="{{ $data->sku_type }}">
                                <input type="hidden" name="delivery_receipt[{{ $data->id }}]" value="{{ $data->delivery_receipt }}">
                                <input type="hidden" name="sku_id[{{ $data->id }}]" value="{{ $data->sku_id }}">
                                <input type="hidden" name="final_quantity[{{ $data->id }}]"
                                    value="{{ $final_quantity[$data->id] }}">
                            </td>
                        </tr>
                    @else
                        <tr style="background:#97e47e">
                            <td>{{ $data->sku_code }}</td>
                            <td>{{ $data->description }}</td>
                            <td>{{ $data->sku_type }}</td>
                            <td style="text-align: right">
                                {{ $data->quantity }}
                                @php
                                    $quantity_sum[] = $data->quantity;
                                @endphp
                            </td>
                            <td style="text-align: right">{{ $final_quantity[$data->id] }}
                                @php
                                    $final_quantity_sum[] = $final_quantity[$data->id];
                                @endphp
                                <input type="hidden" name="id[]" value="{{ $data->id }}">
                                <input type="hidden" name="sku_type[{{ $data->id }}]" value="{{ $data->sku_type }}">
                                <input type="hidden" name="delivery_receipt[{{ $data->id }}]" value="{{ $data->delivery_receipt }}">
                                <input type="hidden" name="sku_id[{{ $data->id }}]" value="{{ $data->sku_id }}">
                                <input type="hidden" name="final_quantity[{{ $data->id }}]"
                                    value="{{ $final_quantity[$data->id] }}">
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Quantity</th>
                    <th style="text-align: right;font-size:30px;">
                        {{ array_sum($quantity_sum) }}
                    </th>
                    <th style="text-align: right">

                        @if (array_sum($quantity_sum) != array_sum($final_quantity_sum))
                            <span style="font-size:30px;color:red;">{{ array_sum($final_quantity_sum) }}</span>
                        @else
                            <span style="font-size:30px;color:green;">{{ array_sum($final_quantity_sum) }}</span>
                        @endif
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
    <input type="hidden" value="{{ $principal->id }}" name="principal_id">
    <button class="btn btn-sm float-right btn-success">Submit</button>

</form>

<script>
    $("#warehouse_saved").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "warehouse_saved",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                });

                location.reload();
            },
            error: function(error) {
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));
</script>
