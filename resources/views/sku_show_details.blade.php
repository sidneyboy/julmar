<form id="sku_add_process">
    @csrf
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-striped table-hover">
            <thead>
                <tr>
                    <th>Sku Code</th>
                    <th>Barcode</th>
                    <th>Principal</th>
                    <th>Description</th>
                    <th>Sku Type</th>
                    <th>Main Category</th>
                    <th>Sub Category</th>
                    <th>UOM</th>
                    <th>Butal Equivalent</th>
                    <th>Weight</th>
                </tr>
            </thead>
            <tbody>
                @if ($sku_type == 'Case')
                    <tr>
                        <td>{{ $sku_code }}
                            <input type="hidden" name="sku_code_case" value="{{ $sku_code }}">
                        </td>
                        <td>{{ $barcode }}
                            <input type="hidden" name="barcode_case" value="{{ $barcode }}">
                        </td>
                        <td>{{ $principal->principal }}
                            <input type="hidden" name="principal_id" value="{{ $principal->id }}">
                        </td>
                        <td>{{ $description }}
                            <input type="hidden" name="description_case" value="{{ $description }}">
                        </td>
                        <td>CASE
                           
                        </td>
                        <td>{{ $main_category->category }}
                            <input type="hidden" name="main_category_id" value="{{ $main_category_id }}">
                        </td>
                        <td>
                            <select name="sub_category_id_case" class="form-control form-control-sm select2bs4">
                                <option value="" default>Select</option>
                                @foreach ($main_category->sub_category as $data)
                                    <option value="{{ $data->id }}">{{ $data->sub_category }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" name="uom_case" class="form-control form-control-sm" required></td>
                        <td>1</td>
                        <td><input type="text" name="weight_case" class="form-control form-control-sm" required></td>
                    </tr>
                    <tr>
                        <td>{{ $sku_code }}
                            <input type="hidden" name="sku_code_butal" value="{{ $sku_code }}">
                        </td>
                        <td>{{ $barcode }}
                            <input type="hidden" name="barcode_butal" value="{{ $barcode }}">
                        </td>
                        <td>{{ $principal->principal }}
                            <input type="hidden" name="principal_id" value="{{ $principal->id }}">
                        </td>
                        <td>{{ $description }}
                            <input type="hidden" name="description_butal" value="{{ $description }}">
                        </td>
                        <td>
                            BUTAL
                        </td>
                        <td>{{ $main_category->category }}
                            <input type="hidden" name="main_category_id" value="{{ $main_category_id }}">
                        </td>
                        <td>
                            <select name="sub_category_id_butal" class="form-control form-control-sm select2bs4">
                                <option value="" default>Select</option>
                                @foreach ($main_category->sub_category as $data)
                                    <option value="{{ $data->id }}">{{ $data->sub_category }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" name="uom_butal" class="form-control form-control-sm" required></td>
                        <td><input type="number" min="1" name="butal_equivalent"
                                class="form-control form-control-sm" required></td>
                        <td><input type="text" name="weight_butal" class="form-control form-control-sm" required>
                            <input type="hidden" name="sku_type" value="Case">
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $sku_code }}
                            <input type="hidden" name="sku_code_butal" value="{{ $sku_code }}">
                        </td>
                        <td>{{ $barcode }}
                            <input type="hidden" name="barcode_butal" value="{{ $barcode }}">
                        </td>
                        <td>{{ $principal->principal }}
                            <input type="hidden" name="principal_id" value="{{ $principal->id }}">
                        </td>
                        <td>{{ $description }}
                            <input type="hidden" name="description_butal" value="{{ $description }}">
                        </td>
                        <td>BUTAL
                            
                        </td>
                        <td>{{ $main_category->category }}
                            <input type="hidden" name="main_category_id" value="{{ $main_category_id }}">
                        </td>
                        <td>
                            <select name="sub_category_id_butal" class="form-control form-control-sm select2bs4"
                                required>
                                <option value="" default>Select</option>
                                @foreach ($main_category->sub_category as $data)
                                    <option value="{{ $data->id }}">{{ $data->sub_category }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" name="uom_butal" class="form-control form-control-sm" required></td>
                        <td><input type="number" min="1" name="butal_equivalent"
                                class="form-control form-control-sm" required></td>
                        <td><input type="text" name="weight_butal" class="form-control form-control-sm" required>
                            <input type="hidden" name="sku_type" value="Butal">
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <br />
    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>

<script>
    $("#sku_add_process").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "sku_add_process",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                //console.log(data);
                if (data == 'saved') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!, Contact IT Support Immediately',
                    })
                }
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
