@if ($uom == 'Case')
    <label>OUT FROM CASE</label>
    <table class="table table-bordered table-sm table-hover">
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>SKU Type</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $sku_add->sku_code }}</td>
                <td>{{ $sku_add->description }}</td>
                <td>{{ $convert }}</td>
                <td>Case
                    <input type="hidden" name="sku_id" value="{{ $sku_add->id }}">
                    <input type="hidden" name="equivalent_sku_id" value="{{ $sku_add->equivalent_sku_entryNo }}">
                </td>
            </tr>
        </tbody>
    </table>

    <label>IN TO BUTAL</label>
    <table class="table table-bordered table-hover table-sm">
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>SKU Type</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $equivalents->sku_code }}</td>
                <td>{{ $equivalents->description }}</td>
                <td>
                    {{ $equivalents->equivalent_butal_pcs * $convert }}</td>
                <td>Butal
                    <input type="hidden" name="equivalent_sku_id" value="{{ $sku_add->equivalent_sku_entryNo }}">
                </td>
            </tr>
        </tbody>
    </table>
@else
    <label>OUT FROM BUTAL</label>
    <table class="table table-bordered table-hover table-sm">
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>SKU Type</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $sku_add->sku_code }}</td>
                <td>{{ $sku_add->description }}</td>
                <td>{{ $sku_add->equivalent_butal_pcs }}</td>
                <td>Butal
                    <input type="hidden" name="sku_id" value="{{ $sku_add->id }}">
                    <input type="hidden" name="equivalent_sku_id" value="{{ $sku_add->equivalent_sku_entryNo }}">
                    <input type="hidden" name="quantity" value="{{ $sku_add->equivalent_butal_pcs }}">
                </td>
            </tr>
        </tbody>
    </table>

    <label>IN TO CASE</label>
    <table class="table table-bordered table-hover table-sm">
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>SKU Type</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $equivalents->sku_code }}</td>
                <td>{{ $equivalents->description }}</td>
                <td>{{ $convert }}</td>
                <td>Case
                    <input type="hidden" name="equivalent_sku_id" value="{{ $sku_add->equivalent_sku_entryNo }}">
                </td>
            </tr>
        </tbody>
    </table>
@endif



<script>
    function saved() {
        var form = document.myform;
        var dataString = $(form).serialize();
        //$('.loading').show();
        $.ajax({
            type: 'POST',
            url: '/bodega_out_saved',
            data: dataString,
            success: function(data) {

                if (data == 'Saved') {
                    toastr.success('BODEGA OUT DATA SUCCESSFULLY SAVED!');
                    $('.loading').show();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);

                } else {
                    toastr.error('Something went wrong, please redo process');
                }

            }
        });
        return false;
    }
</script>
