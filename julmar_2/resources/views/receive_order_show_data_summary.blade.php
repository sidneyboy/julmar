<form id="myform" class="myform" name="myform">
    <center>
        <div class="row" style="width:60%;">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Discount Rate:</label>
                    <select class="form-control select2" name="discount" style="width:100%;">
                        <option value="" default>SELECT PRINCIPAL DISCOUNT RATE</option>
                        @foreach ($select_principal_discount as $data)
                            <option value="{{ $data->id }}">Discount - {{ $data->total_discount }} | Bo Allowance -
                                {{ $data->total_bo_allowance_discount }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Discount Type</label>
                    <select name="discount_type" class="form-control" required>
                        <option value="" default>Select</option>
                        <option value="type_a">Type A(Total & BO Discount)</option>
                        <option value="type_b">Type B(Cascade Discount)</option>
                    </select>
                </div>
            </div>
        </div>
    </center>
    <br /><br />

    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th colspan="5">Purchase Order Details</th>
                </tr>
                <tr>
                    <th>Principal</th>
                    <th>Truck #</th>
                    <th>PO #</th>
                    <th>DR/SI #</th>
                    <th>Branch</th>
                </tr>
            <tbody>
                <tr>
                    <td>{{ $principal_name }}</td>
                    <td>{{ $truck_number }}</td>
                    <td>{{ $purchase_id }}</td>
                    <td>{{ $dr_si }}</td>
                    <td>{{ $branch }}</td>
                </tr>
            </tbody>
            </thead>
        </table>
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Ordered</th>
                    <th>Received</th>
                    <th>UOM</th>
                    <th>Unit Cost</th>
                    <th>Freight</th>
                    <th>Expiratio Date</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchase_order_details as $data)
                    <tr>
                        <td style="text-transform: uppercase;text-align: center;">{{ $data->sku->sku_code }}</td>
                        <td style="text-transform: uppercase;text-align: center;">{{ $data->sku->description }}</td>
                        <td style="text-transform: uppercase;text-align: center;">
                            {{ $data->quantity - $data->receive }}</td>
                        <td><input type="number" class="form-control received_quantity" min="1"
                                name="received_quantity[{{ $data->sku->id }}]"
                                value="{{ $data->quantity - $data->receive }}"></td>
                        <td style="text-transform: uppercase;text-align: center;">{{ $data->sku->unit_of_measurement }}
                        </td>
                        <td><input type="text" class="currency-default" name="unit_cost[{{ $data->sku->id }}]"
                                value="{{ $data->sku->sku_price_details_one->unit_cost }}"
                                style="text-align: center;display: block;
							width: 100%;
							height: calc(2.25rem + 2px);
							padding: .375rem .75rem;
							font-size: 1rem;
							font-weight: 400;
							line-height: 1.5;
							color: #495057;
							background-color: #fff;
							background-clip: padding-box;
							border: 1px solid #ced4da;
							border-radius: .25rem;
							box-shadow: inset 0 0 0 transparent;
						transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
                        </td>

                        <td><input type="text" class="currency-default" name="freight[{{ $data->sku->id }}]"
                                value="{{ $freight }}"
                                style="text-align: center;display: block;
							width: 100%;
							height: calc(2.25rem + 2px);
							padding: .375rem .75rem;
							font-size: 1rem;
							font-weight: 400;
							line-height: 1.5;
							color: #495057;
							background-color: #fff;
							background-clip: padding-box;
							border: 1px solid #ced4da;
							border-radius: .25rem;
							box-shadow: inset 0 0 0 transparent;
						transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
                        </td>
                        <td><input type="text" class="form-control datepicker"
                                name="expiration_date[{{ $data->sku->id }}]" value="none"></td>
                        <td style="text-transform: uppercase;text-align: center;">
                            <select class="form-control select2" name="remarks[{{ $data->sku->id }}]"
                                style="width:100%;">
                                <option value="NO BALANCE" selected>NO BALANCE</option>
                                <option value="SHORT LANDING">SHORT LANDING</option>
                                <option value="DAMAGE">DAMAGE</option>
                                <option value="OVER">OVER</option>
                                <option value="LACKING">LACKING</option>
                                <option value="BALANCE">BALANCE</option>
                            </select>
                            <input type="hidden" name=sku_code[{{ $data->sku->id }}]
                                value="{{ $data->sku->sku_code }}">
                            <input type="hidden" name="description[{{ $data->sku->id }}]"
                                value="{{ $data->sku->description }}">
                            <input type="hidden" name="quantity[{{ $data->sku->id }}]" value="{{ $data->quantity }}">
                            <input type="hidden" name="sku_id[]" value="{{ $data->sku->id }}">
                            <input type="hidden" name="unit_of_measurement[{{ $data->sku->id }}]"
                                value="{{ $data->sku->unit_of_measurement }}">

                            <input type="hidden" name="principal_name" value="{{ $principal_name }}">
                            <input type="hidden" name="branch" value="{{ $branch }}">
                            <input type="hidden" name="principal_id" value="{{ $principal_id }}">
                            <input type="hidden" name="purchase_order_id" value="{{ $purchase_order_id }}">
                            <input type="hidden" name="courier" value="{{ $courier }}">
                            <input type="hidden" name="truck_number" value="{{ $truck_number }}">
                            <input type="hidden" name="dr_si" value="{{ $dr_si }}">
                            <input type="hidden" name="purchase_id" value="{{ $purchase_id }}">
                            <input type="hidden" name="category_id[{{ $data->sku->id }}]"
                                value="{{ $data->sku->category_id }}">
                            <input type="hidden" name="sku_type[{{ $data->sku->id }}]"
                                value="{{ $data->sku->sku_type }}">
                            <input type="hidden" name="invoice_date" value="{{ $invoice_date }}">

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br /><br />
        <center>
            <div class="form-group">
                <div class="col-md-12">
                    <button class="btn btn-info  btn-sm btn-block" type="button"
                        onclick="return generate_final_summary()" style="font-weight: bold;">Generate Final Summary</button>
                </div>

            </div>
        </center>
</form>
</div>



<script>
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

    function generate_final_summary() {
        var form = document.myform;
        var dataString = $(form).serialize();
        $('.loading').show();
        $.ajax({
            type: 'POST',
            url: '/receive_order_data_final_summary',
            data: dataString,
            success: function(data) {

                console.log(data);
                if (data == 'some of your sku doesnt have expiration date.') {
                    Swal.fire(
                        'PLEASE REVIEW EXPIRATION DATE',
                        'SOME OF YOUR SKU DOESNT HAVE EXPIRATE DATE',
                        'error'
                    )
                    $('.loading').hide();
                } else if (data == 'null') {
                    Swal.fire(
                        'TO PROCEED',
                        'SELECT DISCOUNT FIRST, THANK YOU!',
                        'error'
                    )
                    $('.loading').hide();
                } else {
                    $('.loading').hide();
                    $('#show_data_final_summary').html(data);
                    // $('#generate_cifpi_button').prop('disabled', true);

                }
                //           	if (data == 'null') {
                //           		Swal.fire(
                //   'TO PROCEED',
                //   'SELECT DISCOUNT FIRST, THANK YOU!',
                //   'error'
                // )
                //           	}else{
                //           		$('.loading').hide();
                //            	$('#show_data_final_summary').html(data);  
                //            	 // $('#generate_cifpi_button').prop('disabled', true);

                //           	}

            }
        });
        return false;
    }

    $(function() {
        $(".datepicker").datepicker();
        $('.select2').select2()
    });
</script>
