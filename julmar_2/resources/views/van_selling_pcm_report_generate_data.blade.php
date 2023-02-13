<div class="table table-responsive">
    <table class="table table-bordered table-sm table-hover" id="example2">
        <thead>
            <tr>
                <th>Salesman</th>
                <th>Pcm #</th>
                <th>Remitted By</th>
                <th>Store Name</th>
                <th>Encoder</th>
                <th>Date</th>
                <th>Remarks</th>
                <th>Total Pcm Amount</th>
            </tr>
        </thead>
        <tbody>
            @if (count($van_selling_pcm) != 0)
            @foreach ($van_selling_pcm as $data)
            <tr>
                <td>{{ $data->customer->store_name }}</td>
                <td>
                    <button type="button" class="btn btn-link" data-toggle="modal"
                    data-target="#exampleModalLong{{ $data->id }}">
                    {{ $data->pcm_number }}
                    </button>
                    <div class="modal fade" id="exampleModalLong{{ $data->id }}" tabindex="-1"
                        role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                    PCM #: {{ $data->pcm_number }}</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>Principal</th>
                                                <th>Code</th>
                                                <th>Desc</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Sub</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data->van_selling_pcm_details) != 0)
                                                @foreach ($data->van_selling_pcm_details as $details)
                                                    <tr>
                                                        <td>{{ $details->principal }}</td>
                                                        <td>{{ $details->sku_code }}</td>
                                                        <td>{{ $details->description }}</td>
                                                        <td>{{ $details->quantity }}</td>
                                                        <td>{{ $details->unit_price }}</td>
                                                        <td style="text-align: right">
                                                            {{ number_format($details->unit_price * $details->quantity, 2, '.', ',') }}
                                                            @php
                                                            $total[] = round($details->unit_price * $details->quantity,2);
                                                            @endphp
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                 @php
                                                            $total[] = 0;
                                                            @endphp
                                            @endif
                                        </tbody>
                                        <tfoot>
                                          <tr>
                                            <td colspan="5" style="text-align: center">GRAND TOTAL</td>
                                            <td style="text-align: right">
                                            {{ number_format(array_sum($total), 2, '.', ',') }}</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td style="text-transform: uppercase">{{ $data->remitted_by }}</td>
                <td style="text-transform: uppercase">{{ $data->store_name }}</td>
                <td style="text-transform: uppercase">{{ $data->user->name }}</td>
                <td>{{ $data->date }}</td>
                <td style="text-transform: uppercase">
                    @if ($data->remarks != 'to_be_posted')
                    <span style="color:green;font-weight:bold">
                    {{ $data->remarks }}</span>
                    @else
                    <span style="color:red;font-weight:bold">
                    {{ $data->remarks }}</span>
                    @endif
                </td>
                <td style="text-align: right">{{ number_format($data->amount, 2, '.', ',') }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
<script>
$("#example1").DataTable();
$('#example2').DataTable({
"paging": false,
"lengthChange": false,
"searching": true,
"ordering": true,
"info": true,
"autoWidth": false,
});
</script>