<form action="sales_order_draft_update_customer_process" method="post">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <label>SO FOR PRINCIPAL</label>
            <input type="text" value="{{ $sales_order_draft->principal->principal }}" disabled class="form-control">
        </div>
        <div class="col-md-4">
            <label>Mode of Transaction</label>
            <select name="mode_of_transaction" class="form-control" required>
                <option value="" default>Select</option>
                <option value="PDC">PDC</option>
                <option value="COD">COD</option>
                <option value="VALE">VALE</option>
                <option selected value="{{ $customer_check->mode_of_transaction }}">{{ $customer_check->mode_of_transaction }}</option>
            </select>
        </div>

        <div class="col-md-4">
            <label>Store Name</label>
            <input type="text" class="form-control" name="store_name" value="{{ $customer_check->store_name }}" required>
        </div>

        <div class="col-md-4">
            <label>Store Name</label>
            <select name="location_id" class="form-control" required>
                <option value="" default>Select</option>
                <option value="{{ $customer_check->location_id }}" selected>{{ $customer_check->location->location }}
                </option>
                @foreach ($location as $data)
                    <option value="{{ $data->id }}">{{ $data->location }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label>Detailed Location</label>
            <input type="text" class="form-control" name="detailed_location"
                value="{{ $customer_check->detailed_location }}" required>
        </div>

        <div class="col-md-4">
            <label>Credit Term</label>
            <input type="number" min="0" class="form-control" name="credit_term"
                value="{{ $customer_check->credit_term }}" required>
        </div>

        <div class="col-md-4">
            <label>Credit Line Amount</label>
            <input type="text" min="0" class="currency-default" name="credit_line_amount"
                value="{{ $customer_check->credit_line_amount }}" required
                style="display: block;
                width: 100%;
                height: calc(2.25rem + 2px);
                padding: 0.375rem 0.75rem;
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                color: #495057;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
                box-shadow: inset 0 0 0 transparent;
                transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
        </div>

        <div class="col-md-4">
            <label>Contact Person</label>
            <input type="text" class="form-control" name="contact_person"
                value="{{ $customer_check->contact_person }}" required>
        </div>

        <div class="col-md-4">
            <label>Contact Number</label>
            <input type="text" class="form-control" name="contact_number"
                value="{{ $customer_check->contact_number }}" required>
        </div>

        <div class="col-md-4">
            <label>Kind of Business</label>
            <select name="kind_of_business" class="form-control select2" required>
                <option value="" default>Select</option>
                <option value="SSS">SSS</option>
                <option value="GRO">GRO</option>
                <option value="SM">SM</option>
                <option value="DS">DS</option>
                <option value="PMS">PMS</option>
                <option value="CNV">CNV</option>
                <option value="HWA">HWA</option>
                <option value="WS">WS</option>
                <option value="HLS">HLS</option>
                <option value="TER">TER</option>
                <option value="INST">INST</option>
                <option value="{{ $customer_check->kind_of_business }}" selected>
                    {{ $customer_check->kind_of_business }}</option>
            </select>
        </div>

        <div class="col-md-4">
            <label>Max Number of Transactions Allowed</label>
            <input type="text" class="form-control" name="max_number_of_transactions"
                value="{{ $customer_check->max_number_of_transactions }}" required>
        </div>

        <div class="col-md-4">
            <label>Longitude</label>
            <input type="text" class="form-control" name="longitude" value="{{ $customer_check->longitude }}"
                required>
        </div>

        <div class="col-md-4">
            <label>Latitude</label>
            <input type="text" class="form-control" name="latitude" value="{{ $customer_check->latitude }}"
                required>
        </div>

        <div class="col-md-4">
            <label>Customer Principal Code</label>
            @if (isset($customer_principal_code))
                <input class="form-control" type="text" name="customer_principal_code"
                    value="{{ $customer_principal_code->store_code }}" required>
            @else
                <input class="form-control" type="text" name="customer_principal_code" required>
            @endif
        </div>
        <div class="col-md-4">
            <label>Price Level</label>
            @if (isset($customer_principal_price))
                <select name="customer_principal_price" class="form-control select2" required>
                    <option value="" default>Select</option>
                    <option value="price_1">Price 1</option>
                    <option value="price_2">Price 2</option>
                    <option value="price_3">Price 3</option>
                    <option value="price_4">Price 4</option>
                    <option value="{{ $customer_principal_price->price_level }}" selected>{{ $customer_principal_price->price_level }}</option>
                </select>
            @else
                <select name="customer_principal_price" class="form-control select2" required>
                    <option value="" default>Select</option>
                    <option value="price_1">Price 1</option>
                    <option value="price_2">Price 2</option>
                    <option value="price_3">Price 3</option>
                    <option value="price_4">Price 4</option>
                </select>
            @endif
        </div>

        <div class="col-md-12">
            <br />
            <input type="hidden" name="customer_id" value="{{ $customer_check->id }}">
            <input type="hidden" name="principal_id" value="{{ $sales_order_draft->principal_id }}">
            <button class="btn btn-success btn-block" type="submit">Submit</button>
        </div>
    </div>
</form>


<script>
    $('.select2').select2();
    $('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({
        decimal: '_',
        thousands: '*'
    });
    $('[class=integer-default]').maskNumber({
        integer: true
    });
    $('[class=integer-data-attribute]').maskNumber({
        integer: true
    });
    $('[class=integer-configuration]').maskNumber({
        integer: true,
        thousands: '_'
    });
</script>
