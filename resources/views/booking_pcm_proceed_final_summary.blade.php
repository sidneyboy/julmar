<form id="booking_pcm_save">
    <div class="row">
        <div class="col-md-6">
            <label for="">Delivery Receipt:</label>
            <input type="text" name="delivery_receipt" required class="form-control">
        </div>
        <div class="col-md-6">
            <label for="">PCM #:</label>
            <input type="text" name="pcm_number" required class="form-control">
        </div>
    </div>
    <br />
    <table class="table table-bordered table-sm table-striped">
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>U/P</th>
                <th>Sub-Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $data)
                <tr>
                    <td>{{ $data->associatedModel->sku_code }}</td>
                    <td>{{ $data->name }}</td>
                    <td style="text-align: right">{{ $data->quantity }}</td>
                    <td style="text-align: right">{{ $data->price }}</td>
                    <td style="text-align: right">
                        @php
                            $sub_total = $data->quantity * $data->price;
                            $sum_total[] = $sub_total;
                            echo number_format($sub_total, 2, '.', ',');
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
            </tr>
        </tfoot>
    </table>
    <br />
    <input type="hidden" value="{{ array_sum($sum_total) }}" name="total_amount">
    <input type="hidden" value="{{ $principal_id }}" name="principal_id">
    <input type="hidden" value="{{ $sku_type }}" name="sku_type">
    <input type="hidden" value="{{ $pcm_type }}" name="pcm_type">
    <input type="hidden" value="{{ $agent_id }}" name="agent_id">
    <input type="hidden" value="{{ $customer_id }}" name="customer_id">
    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>

<script>
    $("#booking_pcm_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "booking_pcm_save",
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
                $('#loader').hide();
            }
        });
    }));
</script>
