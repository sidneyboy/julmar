<div class="table table-responsive">
    <table class="table table-bordered table-striped table-sm" style="width:100%;font-size:11px;" id="example1">
        <thead>
            <tr>
                <th>Principal</th>
                <th>Transaction Date</th>
                <th>Description</th>
                <th>DR</th>
                <th>CR</th>
                <th>Running</th>
                <th>Remarks</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ap_ledger as $data)
                @if ($data->transaction == 'beginning')
                    <tr style="background-color:greenyellow">
                        <td>{{ $data->principal->principal }}</td>
                        <td>{{ $data->transaction_date }}</td>
                        <td>{{ $data->description }}</td>
                        <td style="text-align: right">{{ number_format($data->debit_record, 2, '.', ',') }}
                            @if ($data->transaction != 'cut off' and $data->transaction != 'beginning')
                                @php
                                    $total_dr[] = $data->debit_record;
                                @endphp
                            @else
                                @php
                                    $total_dr[] = 0;
                                @endphp
                            @endif
                        </td>
                        <td style="text-align: right">{{ number_format($data->credit_record, 2, '.', ',') }}
                            @if ($data->transaction != 'cut off' and $data->transaction != 'beginning')
                                @php
                                    $total_cr[] = $data->credit_record;
                                @endphp
                            @else
                                @php
                                    $total_cr[] = 0;
                                @endphp
                            @endif
                        </td>
                        <td style="text-align: right">{{ number_format($data->running_balance, 2, '.', ',') }}</td>
                        <td>{{ $data->remarks }}</td>
                        <td>{{ $data->user->name }}</td>
                    </tr>
                @elseif($data->transaction == 'cut off')
                    <tr style="background-color:red">
                        <td>{{ $data->principal->principal }}</td>
                        <td>{{ $data->transaction_date }}</td>
                        <td>{{ $data->description }}</td>
                        <td style="text-align: right">{{ number_format($data->debit_record, 2, '.', ',') }}
                            @if ($data->transaction != 'cut off' and $data->transaction != 'beginning')
                                @php
                                    $total_dr[] = $data->debit_record;
                                @endphp
                            @else
                                @php
                                    $total_dr[] = 0;
                                @endphp
                            @endif
                        </td>
                        <td style="text-align: right">{{ number_format($data->credit_record, 2, '.', ',') }}
                            @if ($data->transaction != 'cut off' and $data->transaction != 'beginning')
                                @php
                                    $total_cr[] = $data->credit_record;
                                @endphp
                            @else
                                @php
                                    $total_cr[] = 0;
                                @endphp
                            @endif
                        </td>
                        <td style="text-align: right">{{ number_format($data->running_balance, 2, '.', ',') }}</td>
                        <td>{{ $data->remarks }}</td>
                        <td>{{ $data->user->name }}</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $data->principal->principal }}</td>
                        <td>{{ $data->transaction_date }}</td>
                        <td>{{ $data->description }}</td>
                        <td style="text-align: right">{{ number_format($data->debit_record, 2, '.', ',') }}
                            @if ($data->transaction != 'cut off' and $data->transaction != 'beginning')
                                @php
                                    $total_dr[] = $data->debit_record;
                                @endphp
                            @else
                                @php
                                    $total_dr[] = 0;
                                @endphp
                            @endif
                        </td>
                        <td style="text-align: right">{{ number_format($data->credit_record, 2, '.', ',') }}
                            @if ($data->transaction != 'cut off' and $data->transaction != 'beginning')
                                @php
                                    $total_cr[] = $data->credit_record;
                                @endphp
                            @else
                                @php
                                    $total_cr[] = 0;
                                @endphp
                            @endif
                        </td>
                        <td style="text-align: right">{{ number_format($data->running_balance, 2, '.', ',') }}</td>
                        <td>{{ $data->remarks }}</td>
                        <td>{{ $data->user->name }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right">{{ number_format(array_sum($total_dr), 2, '.', ',') }}</td>
                <td style="text-align: right">{{ number_format(array_sum($total_cr), 2, '.', ',') }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

<br />

<form id="ap_ledger_subsidiary_cut_off_save">
    <label for="">Remarks</label>
    <textarea name="remarks" class="form-control" cols="30" rows="3" required></textarea>
    <input type="hidden" name="principal_id" value="{{ $ap_ledger[0]->principal_id }}">
    <br />
    <button class="float-right btn-sm btn-success">Cut Off</button>
</form>
<br /><br />


<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            responsive: true,
            paging: false,
            ordering: true,
            info: false,
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                {
                    extend: 'csvHtml5',
                    filename: 'SUBSIDIARY AP LEDGER',
                    title: 'SUBSIDIARY AP LEDGER',
                },

            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });

    ap_ledger_subsidiary_cut_off_save

    $("#ap_ledger_subsidiary_cut_off_save").on('submit', (function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure you want to cut off?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#loader').show();
                $.ajax({
                    url: "ap_ledger_subsidiary_cut_off_save",
                    type: "post",
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
            }
        })
    }));
</script>
