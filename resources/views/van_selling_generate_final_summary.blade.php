<form id="van_selling_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead>
                <tr>
                    <th colspan="4" style="text-align: center;">{{ $customer->store_name }}</th>
                    <th colspan="4" style="text-align: center;">{{ $delivery_receipt }}</th>
                </tr>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Qty Butal</th>
                    <th>Equivalent Pcs</th>
                    <th>Qty Case</th>
                    <th>Butal Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $data)
                    <tr>
                        <td>{{ $data->associatedModel->sku_code }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->associatedModel->sku_type }}</td>
                        <td style="text-align: right">{{ $data->quantity }}
                            @php
                                $sum_quantity[] = $data->quantity;
                            @endphp
                        </td>
                        <td style="text-align: right">{{ $data->associatedModel->equivalent_butal_pcs}}
                        </td>
                        <td style="text-align: right">{{ $data->associatedModel->sku_ledger_latest->running_balance / $data->quantity }}
                        </td>
                        <td style="text-align: right">{{ number_format($data->price, 2, '.', ',') }}</td>
                        <td style="text-align: right">
                            @php
                                $total = $data->quantity * $data->price;
                                $sum_total[] = $total;
                                echo number_format($total, 2, '.', ',');
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th style="text-align: right">{{ array_sum($sum_quantity) }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="form-group">
        <input type="hidden" name="delivery_receipt" value="{{ $delivery_receipt }}">
        <input type="hidden" name="customer_id" value="{{ $customer_id }}">
        <input type="hidden" name="principal_id" value="{{ $principal_id }}">
        <input type="hidden" name="total_amount" value="{{ array_sum($sum_total) }}">
        <button type="submit" class="btn btn-success btn-sm float-right">Submit</button>
    </div>
</form>

<script type="text/javascript">
    $("#van_selling_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "van_selling_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(res) {
                $('#loader').hide();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                })

                location.reload();
            },
            error: function(res) {
                $('#loader').hide();
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));

    $(".example1").DataTable();
    $('.example2').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });
</script>
