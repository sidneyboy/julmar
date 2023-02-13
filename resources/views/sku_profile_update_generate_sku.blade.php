<div class="table table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>UOM</th>
                <th>Principal</th>
                <th>Category</th>
                <th>Kilograms</th>
                <th>Grams</th>
                <th>Liter</th>
                <th>Millileter</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sku as $data)
                <tr>
                    <td>{{ $data->sku_code }}</td>
                    <td>
                        <input type="text" value="{{ $data->description }}" class="form-control">
                    </td>
                    <td>
                        <input type="text" value="{{ $data->unit_of_measurement }}" class="form-control">
                    </td>
                    <td>
                        <select name="principal_id" class="form-control select2" style="width:100%">
                            <option value="{{ $data->skuPrincipal->id }}" selected>{{ $data->skuPrincipal->principal }}</option>
                            @foreach ($principal as $principal_data)
                                <option value="{{ $principal_data->id }}">{{ $principal_data->principal }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="category_id" class="form-control select2" style="width:100%">
                            <option value="{{ $data->category_id }}" selected>{{ $data->skuCategory->category }}</option>
                            {{-- @foreach ($category as $category_data)
                                <option value="{{ $category_data->id }}">{{ $category_data->category }}</option>
                            @endforeach --}}
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>