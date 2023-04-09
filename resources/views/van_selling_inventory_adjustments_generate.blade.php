<form id="van_selling_inventory_adjustments_generate_final_summary">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm" id="example1">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Ending Inventory</th>
                    <th>Adjustment</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sku_ledger as $data)
                    <tr>
                        <td><span style="color:green;font-weight:bold">{{ $data->sku_code }}</span> -
                            {{ $sku[$data->sku_id]->description }}
                        </td>
                        <td style="text-align: right">{{ $data->ending_inventory }}</td>
                        <td><input type="number" value="0" name="confirmed_quantity[{{ $data->id }}]"
                                class="form-control form-control-sm" style="text-align: center"></td>
                        <td><input type="text" class="form-control form-control-sm"
                                name="remarks[{{ $data->id }}]">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
    <button class="btn btn-sm float-right btn-info" type="submit">Generate Summary</button>
</form>


<script>
    $('#example1').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": false,
    });



    $("#van_selling_inventory_adjustments_generate_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "van_selling_inventory_adjustments_generate_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                $('#van_selling_inventory_adjustments_generate_final_summary_page').html(data);
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
