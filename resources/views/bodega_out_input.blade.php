<form id="bodega_out_summary">
    @csrf
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label>Sku</label>
                <select name="sku" id="sku" required class="form-control select2bs4" style="width:100%;">
                    <option value="" default>Select Sku</option>
                    @foreach ($sku_add as $data)
                        <option value="{{ $data->id }}">
                            {{ $data->sku_code . ' - ' . $sku_type . ' - ' . $data->description }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Equivalent</label>
                <input type="number" id="equivalent" style="text-align: center" required class="form-control" disabled>
                <input type="hidden" value="{{ $principal_id }}" name="principal_id">
                <input type="hidden" value="{{ $sku_type }}" name="sku_type">
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>Convert(Case Bases)</label>
                <input type="number" required class="form-control" name="convert">
            </div>
        </div>
        <div class="col-md-12">
            <button class="float-right btn btn-info btn-sm" type="submit">Generate</button>
        </div>
    </div>
</form>


<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $('#sku').on('change', function(e) {
        var sku = $(this).val();
        $('#loader').show();
        $.post({
            type: "POST",
            url: "/show_equivalent",
            data: 'sku=' + sku,
            success: function(data) {
                $('#loader').hide();
                $('#equivalent').val(data);
                $('#equivalent_data').val(data);

            },
            error: function(error) {
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
                $('#loader').hide();
            }
        });
    });

    $("#bodega_out_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "bodega_out_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'There is no equivalent butal for this SKU') {
                    $('#loader').hide();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: data,
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else if (data == 'There is no equivalent case for this SKU') {
                    $('#loader').hide();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: data,
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    $('#loader').hide();
                    $('#show_bodega_out_summary').html(data);
                }
            },
            error: function(error) {
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
                $('#loader').hide();
            }
        });
    }));
</script>
