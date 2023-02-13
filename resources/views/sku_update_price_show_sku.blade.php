<form id="generate_sku_price_inputs">
    @csrf
    <div class="form-group">
        <label>Sku</label>
        <select class="form-control select2bs4" name="sku[]" multiple style="width:100%;">
            @foreach ($sku as $data)
                <option value="{{ $data->sku_code }}">
                    {{ $data->sku_code . ' - ' . $data->description . ' - ' . $data->sku_type }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <input type="hidden" name="principal_id" value="{{ $principal_id }}">
        <button type="submit" class="btn btn-info btn-sm float-right">Generate</button>
    </div>
</form>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.select2').select2()

    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $("#generate_sku_price_inputs").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();

        $.ajax({
            url: "sku_update_price_generate_price_inputs",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('.loading').hide();

                $('#sku_update_price_generate_price_inputs').html(data);
            },
        });
    }));
</script>
