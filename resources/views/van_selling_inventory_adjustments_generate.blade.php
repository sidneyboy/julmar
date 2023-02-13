<form id="van_selling_inventory_adjustments_generate_final_summary">
    <div class="row">
        <div class="col-md-6">
            <div class="table table-responsive">
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr>
                            <th colspan="9" style="text-align: center">NEGATIVE QUANTITY(FOR INVENTORY ADJUSTMENTS)</th>
                        </tr>
                        <tr>
                            <th>PRINCIPAL</th>
                            <th>CODE</th>
                            <th>DESCRIPTION</th>
                            <th>UOM</th>
                            <th>ENDING BALANCE</th>
                            <th>INVENTORY ADJUSTMENTS</th>
                            <th>FINAL QTY</th>
                            <th>U/P</th>
                            <th>REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sku as $data)
                            @if ($data->attributes->quantity_adjustments < 0)
                                <tr>
                                    <td>{{ $data->attributes->principal }}</td>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->attributes->unit_of_measurement }}</td>
                                    <td style="text-align: right;">{{ $data->attributes->ending_balance }}</td>
                                    <td style="text-align: right">{{ $data->attributes->quantity_adjustments }}</td>
                                    <td style="text-align: right;">{{ $data->attributes->final_quantity }}</td>
                                    <td style="text-align: right;">{{ $data->price }}</td>
                                    <td>{{ $data->attributes->remarks }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table table-responsive">
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr>
                            <th colspan="9" style="text-align: center">POSITIVE QUANTITY(FOR INVENTORY VAN LOAD)</th>
                        </tr>
                        <tr>
                            <th>PRINCIPAL</th>
                            <th>CODE</th>
                            <th>DESCRIPTION</th>
                            <th>UOM</th>
                            <th>ENDING BALANCE</th>
                            <th>INVENTORY ADJUSTMENTS</th>
                            <th>FINAL QTY</th>
                            <th>U/P</th>
                            <th>REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sku as $data)
                            @if ($data->attributes->quantity_adjustments > 0)
                                <tr>
                                    <td>{{ $data->attributes->principal }}</td>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->attributes->unit_of_measurement }}</td>
                                    <td style="text-align: center;">{{ $data->attributes->ending_balance }}</td>
                                    <td style="text-align: right">{{ $data->attributes->quantity_adjustments }}</td>
                                    <td style="text-align: right;">{{ $data->attributes->final_quantity }}</td>
                                    <td style="text-align: right;">{{ $data->price }}</td>
                                    <td>{{ $data->attributes->remarks }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <label>Remarks</label>
            <input type="text" class="form-control" required name="remarks"> 
        </div>
    </div>
    <br />
    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
    <button type="submit" class="btn btn-info btn-block">PROCEE TO FINAL SUMMARY</button>
</form>
<script type="text/javascript">
    $("#van_selling_inventory_adjustments_generate_final_summary").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $.ajax({
            url: "van_selling_inventory_adjustments_generate_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'NO_DATA') {
                    Swal.fire(
                        'NO DATA FOUND',
                        'NO DR FOR THE MOMENT',
                        'error'
                    )
                    $('.loading').hide();
                } else {
                    $('.loading').hide();
                    $('#van_selling_inventory_adjustments_generate_final_summary_page').html(
                        data);
                }
            },
        });
    }));
</script>
