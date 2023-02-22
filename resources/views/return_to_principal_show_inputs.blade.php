<form id="return_to_principal_summary">
    @csrf
    <div class="form-group">
        <label>Remarks</label>
        <select name="remarks" id="remarks" class="form-control" required>
            <option value="" default>Select Remarks</option>
            <option value="Good Stock">Good Stock</option>
            <option value="Bad Stock">Bad Stock</option>
            <option value="Expire">Expire</option>
            <option value="Near Expire">Near Expire</option>
        </select>
    </div>
    <div class="form-group">
        <label>Driver</label>
        <input type="text" name="personnel" class="form-control" required>
    </div>
    <input type="hidden" value="{{ $principal_id }}" name="principal_id">
    <input type="hidden" value="{{ $received_id }}" name="received_id">

    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Qty Received</th>
                    <th>Qty To Be Return</th>
                    <th>Cost</th>
                    <th style="text-align: center;"><input type="checkbox" onclick="toggle(this);" class="big-checkbox" /></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($received as $data)
                    <tr>
                        <td>{{ $data->sku->sku_code }}</td>
                        <td>{{ $data->sku->description }}</td>
                        <td>{{ $data->sku->sku_type }}</td>
                        <td>{{ $data->quantity }}</td>
                        <td><input type="number" name="quantity[{{ $data->sku_id }}]" class="form-control">
                            <input type="hidden" name="freight[{{ $data->sku_id }}]" value="{{ $data->freight }}" class="form-control">
                        </td>
                        <td style="text-align: right;"><input type="hidden" name="unit_cost[{{ $data->sku_id }}]"
                                value="{{ $data->unit_cost }}">{{ number_format($data->unit_cost, 2, '.', ',') }}
                        </td>
                        <td>
                            <center><input type="checkbox" name="checkbox_entry[]" value="{{ $data->sku->id }}"
                                    class="big-checkbox" /></center>
                            <input type="hidden" name="code[{{ $data->sku_id }}]" value="{{ $data->sku->sku_code }}">
                            <input type="hidden" name="description[{{ $data->sku_id }}]"
                                value="{{ $data->sku->description }}">
                            <input type="hidden" name="sku_type[{{ $data->sku_id }}]"
                                value="{{ $data->sku->sku_type }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
    </div>
    </table>

    <button class="float-right btn btn-info btn-sm" type="submit" style="font-weight: bold;">Generate Final
        Summary</button>
</form>
<script>
    // $('.select2').select2();

    function toggle(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }

    $("#return_to_principal_summary").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "return_to_principal_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);

                if (data == 'no_quantity') {
                    $('.loading').hide();

                } else if (data == 'no remarks') {
                    $('.loading').hide();

                } else if (data == 'no personnel') {
                    $('.loading').hide();

                } else {
                    $('.loading').hide();
                    $('#show_final_summary').show(data);
                    $('#show_final_summary').html(data);
                }
            },
        });
    }));

    // function generate_summary() {

    //     var form = document.myform;
    //     var dataString = $(form).serialize();
    //     $('.loading').show();

    //     $.ajax({
    //         type: 'POST',
    //         url: '/return_to_principal_summary',
    //         data: dataString,
    //         success: function(data) {





    //         }
    //     });
    //     return false;
    // }
</script>
