<form id="update_sku_price">
    <table class="table table-bordered table-hover" id="example2">
        <thead>
            <tr>
                <th>CODE</th>
                <th>DESCRIPTION</th>
                <th>TYPE</th>
                <th>U/C</th>
                <th>P1</th>
                <th>P2</th>
                <th>P3</th>
                <th>P4</th>
                <th>P5</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sku as $data)
                <tr>
                    <td>
                        {{-- 					{{ $data->id }} --}}
                        {{ $data->sku_code }}
                        {{-- 
						{{ $data->sku_price_details_one->id }} --}}
                        <input type="hidden" name="sku_id[]" value="{{ $data->id }}">
                        <input type="hidden" name="sku_code[{{ $data->id }}]" value="{{ $data->sku_code }}">

                    </td>
                    <td>{{ $data->description }}</td>
                    <td>
                        @if ($data->sku_type == 'CASE' or $data->sku_type == 'Case')
                            <span style="font-weight:bold;color:green">{{ $data->sku_type }}</span>
                        @else
                            <span style="font-weight:bold;color:red">{{ $data->sku_type }}</span>
                        @endif
                        <input type="hidden" name="sku_type[{{ $data->id }}]" value="{{ $data->sku_type }}">
                    </td>
                    <td>
                        <input type="text" class="form-control" style="text-align: center;"
                            name="unit_cost[{{ $data->id }}]"
                            value="{{ $data->sku_price_details_one->unit_cost }}">
                    </td>
                    <td>
                        <input type="text" class="form-control" style="text-align: center;"
                            name="price_1[{{ $data->id }}]" value="{{ $data->sku_price_details_one->price_1 }}">
                    </td>
                    <td>
                        <input type="text" class="form-control" style="text-align: center;"
                            name="price_2[{{ $data->id }}]" value="{{ $data->sku_price_details_one->price_2 }}">
                    </td>
                    <td>
                        <input type="text" class="form-control" style="text-align: center;"
                            name="price_3[{{ $data->id }}]" value="{{ $data->sku_price_details_one->price_3 }}">
                    </td>
                    <td>
                        <input type="text" class="form-control" style="text-align: center;"
                            name="price_4[{{ $data->id }}]" value="{{ $data->sku_price_details_one->price_4 }}">
                    </td>
                    <td>
                        <input type="text" class="form-control" style="text-align: center;"
                            name="price_5[{{ $data->id }}]" value="{{ $data->sku_price_details_one->price_5 }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-12">
            {{-- <label style="color:blue;">Inventory Head Permission Key:</label>
			<input type="password" name="secret_key" placeholder="INVENTORY HEAD PERMISSION KEY.." class="form-control" required> --}}
            <label>&nbsp;</label>
            <input type="hidden" name="principal_id" value="{{ $principal_id }}">
            <button type="submit" class="btn btn-success float-right btn-sm">Update Prices</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $("#update_sku_price").on('submit', (function(e) {
        e.preventDefault();
        //alert('asdasd');
        //$('.loading').show();
        $.ajax({
            url: "sku_update_price_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                })
                location.reload();
                $('.loading').hide();
            },
            error: function(error) {
                console.log(error);
            }
        });
    }));
</script>
