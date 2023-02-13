
<form id="van_selling_pcm_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-hover">
            <thead>
                <tr>
                    <th>PCM Type:</th>
                    <th>Salesman:</th>
                    <th>Remitted By:</th>
                    <th>PCM #:</th>
                    <th>Store Name:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-transform: uppercase;">{{ $pcm_type }}</td>
                    <td>{{ $agent_name }}</td>
                    <td>{{ $remitted_by }}</td>
                    <td>{{ $pcm_number }}</td>
                    <td>{{ $store_name }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table table-responsive">
        @if ($pcm_type != 'customer')
            <table class="table table-bordered table-sm table-hover">
                <thead>
                    <tr>
                        <th>Principal</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Sub-Total</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($van_selling_pcm_data as $data)
                        <tr>
                            <td>{{ $data->attributes->principal }}</td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->name }}</td>
                            <td style="text-align: right">{{ $data->quantity }}</td>
                            <td style="text-align: right">{{ number_format($price[$data->id], 4, '.', ',') }}
                                <input type="hidden" value="{{ $price[$data->id] }}" name="price[{{ $data->id }}]">
                            </td>
                            <td style="text-align: right">
                                @php
                                    $sub_total = $price[$data->id] * $data->quantity;
                                    $total_sum[] = round($sub_total, 2);
                                    echo number_format($sub_total, 2, '.', ',');
                                @endphp
                            </td>
                            <td>{{ $data->attributes->remarks }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th style="text-align: center" colspan="5">Total</th>
                        <th style="text-align: right">{{ number_format(array_sum($total_sum), 2, '.', ',') }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        @else
            <table class="table table-bordered table-sm table-hover">
                <thead>
                    <tr>
                        <th>Principal</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Sub-Total</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($van_selling_pcm_data as $data)
                        <tr>
                            <td>{{ $data->attributes->principal }}</td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->name }}</td>
                            <td style="text-align: right">{{ $data->quantity }}</td>
                            
                            <td style="text-align: right">
                                {{ number_format($price[$data->id], 4, '.', ',') }}
                                <input type="hidden" value="{{ $price[$data->id] }}" name="price[{{ $data->id }}]">
                            </td> 
                            <td style="text-align: right">
                                @php
                                    $sub_total = $price[$data->id] * $data->quantity;
                                    $total_sum[] = round($sub_total, 2);
                                    echo number_format($sub_total, 2, '.', ',');
                                @endphp
                            </td>
                            <td>{{ $data->attributes->remarks }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th style="text-align: center" colspan="5">Total</th>
                        <th style="text-align: right">{{ number_format(array_sum($total_sum), 2, '.', ',') }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        @endif
    </div>

    <div class="row">
        <input type="hidden" name="store_name" value="{{ $store_name }}">
        <input type="hidden" name="agent_id" value="{{ $agent_id }}">
        <input type="hidden" name="pcm_type" value="{{ $pcm_type }}">
        <input type="hidden" name="agent_name" value="{{ $agent_name }}">
        <input type="hidden" name="pcm_number" value="{{ $pcm_number }}">
        <input type="hidden" name="remitted_by" value="{{ $remitted_by }}">
        <input type="hidden" name="amount" value="{{ array_sum($total_sum) }}">
        <button type="submit" class="btn btn-success btn-block">Submit Pcm Transaction</button>
    </div>
</form>

<script>
    $('.select2').select2();

    $("#van_selling_pcm_save").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $.ajax({
            url: "van_selling_pcm_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                 $('.loading').hide();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    location.reload();
                // if (data == 'saved') {
                //     $('.loading').hide();
                //     Swal.fire({
                //         position: 'top-end',
                //         icon: 'success',
                //         title: 'Your work has been saved',
                //         showConfirmButton: false,
                //         timer: 1500
                //     });

                //     location.reload();
                // } else {
                //     Swal.fire(
                //         'Something went wrong Please Contact Geraldin Sajulan',
                //         $data,
                //         'error'
                //     )
                //     $('.loading').hide();
                // }
            },
        });
    }));
</script>
