<form id="van_selling_pcm_post_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Transacted</th>
                    <th>Agent</th>
                    <th>Type</th>
                    <th>Principal</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ date('F j, Y', strtotime($pcm->created_at)) }}</td>
                    <td>{{ $pcm->user->name }}</td>
                    <td>{{ $pcm->customer->store_name }}</td>
                    <td>{{ Str::ucfirst($pcm->pcm_type) }}</td>
                    <td>{{ $pcm->principal->principal }}</td>
                    <td style="text-align: right">{{ number_format($pcm->total_amount, 2, '.', ',') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-striped">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Quantity</th>
                    <th>U/P</th>
                    <th>Sub-Total</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pcm->pcm_details as $data)
                    <tr>
                        <td><span style="color:green;font-weight:bold">{{ $data->sku->sku_code }}</span> -
                            {{ $data->sku->description }}</td>
                        <td style="text-align: right">{{ $data->quantity }}</td>
                        <td style="text-align: right">{{ number_format($data->unit_price, 2, '.', ',') }}</td>
                        <td style="text-align: right">
                            @php
                                $total = $data->quantity * $data->unit_price;
                                $sum_total[] = $total;
                                echo number_format($total, 2, '.', ',');
                            @endphp
                        </td>
                        <td>{{ $data->remarks }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <input type="hidden" value="{{ $pcm->id }}" name="pcm_id">
    <button class="btn btn-sm float-right btn-success">Submit</button>
</form>

<script>
    $("#van_selling_pcm_post_save").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "van_selling_pcm_post_save",
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
