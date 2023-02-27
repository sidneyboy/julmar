<form id="receive_order_data_final_summary">
    <div class="row">
        <div class="col-md-6">
            <label for="">BO Allowance Selected:</label>
            <select class="form-control" name="bo_allowance_discount_selected" style="width:100%;" required>
                <option value="{{ $purchase_order->bo_allowance_discount_rate }}" selected>BO Allowance Selected
                    {{ $purchase_order->bo_allowance_discount_rate }}</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="">Discount Type Selected:</label>
            <select name="discount_type" class="form-control" required>
                @if ($purchase_order->discount_type == 'type_a')
                    <option value="{{ $purchase_order->discount_type }}" selected>Type A(Total & BO Discount)</option>
                @else
                    {{ $purchase_order->discount_type }}
                    <option value="{{ $purchase_order->discount_type }}" selected>Type B(Cascade Discount)</option>
                @endif
            </select>
        </div>
        <div class="col-md-12">
            <label for="">Discounts Selected:</label>
            <select class="form-control select2" name="discount_selected[]" multiple="multiple" required
                style="width:100%;">
                <option value="" default>Select</option>
                @foreach ($purchase_order->purchase_order_discount_details as $data)
                    <option value="{{ $data->id }}" selected>{{ $data->discount_name }} - {{ $data->discount_rate }}%</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Less Other Discounts:</label>
                <select class="form-control select2" name="less_other_discount_selected[]" multiple="multiple"
                    style="width:100%;">
                    @foreach ($purchase_order->purchase_order_other_discount_details as $data)
                        <option value="" selected>{{ $data->discount_name }} - {{ $data->discount_rate }}%
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
    <br />

    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th colspan="6">Purchase Order Details</th>
                </tr>
                <tr>
                    <th>Session #</th>
                    <th>Principal</th>
                    <th>Truck #</th>
                    <th>PO #</th>
                    <th>DR/SI #</th>
                    <th>Branch</th>
                </tr>
            <tbody>
                <tr>
                    <td>{{ $session_id }}</td>
                    <td>{{ $principal_name }}</td>
                    <td>{{ $truck_number }}</td>
                    <td>{{ $purchase_id }}</td>
                    <td>{{ $dr_si }}</td>
                    <td>{{ $branch }}</td>
                </tr>
            </tbody>
            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-md-4">
            <table class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th colspan="2">Confirmed Purchase Order From <span
                                style="color:red">{{ $principal_name }}</span></th>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase_order_details as $data)
                        <tr>
                            <td><span style="color:green;font-weight:bold;">{{ $data->sku->sku_code }}</span> -
                                {{ $data->sku->description }}
                            </td>
                            <td>{{ $data->confirmed_quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-8">
            <div class="table table-responsive">
                <table class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr>
                            <th colspan="4">Purchase Order Draft By Warehouse Custodian (<span
                                    style="color:orange;font-weight:bold;">{{ $draft[0]->user->name }}</span>)</th>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Unit Cost(VAT EX)</th>
                            <th>Freight</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($draft as $data)
                            <tr>
                                <td><span style="color:green;font-weight:bold;">{{ $data->sku->sku_code }}</span>-
                                    {{ $data->sku->description }}
                                    <input type="hidden" value="{{ $data->sku->id }}" name="sku_id[]">
                                    <input type="hidden" value="{{ $data->sku->sku_code }}"
                                        name="sku_code[{{ $data->sku->id }}]">
                                    <input type="hidden" value="{{ $data->sku->description }}"
                                        name="description[{{ $data->sku->id }}]">
                                </td>
                                <td><input style="text-align: right" type="number" class="form-control form-control-sm"
                                        onkeypress="return isNumberKey(event)" value="{{ $data->quantity }}"
                                        name="received_quantity[{{ $data->sku->id }}]" required min="0">
                                <td><input style="text-align: right" type="text" class="form-control form-control-sm"
                                        onkeypress="return isNumberKey(event)" name="unit_cost[{{ $data->sku->id }}]"
                                        value="{{ $data->unit_cost }}"></td>
                                <td><input style="text-align: right" type="text" class="form-control form-control-sm"
                                        onkeypress="return isNumberKey(event)" value="{{ $data->freight }}"
                                        name="freight[{{ $data->sku->id }}]" required>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- <input type="hidden" name="freight" value="{{ $freight }}"> --}}
    <input type="hidden" name="principal_name" value="{{ $principal_name }}">
    <input type="hidden" name="branch" value="{{ $branch }}">
    <input type="hidden" name="principal_id" value="{{ $principal_id }}">
    <input type="text" name="purchase_order_id" value="{{ $purchase_order_id }}">
    <input type="hidden" name="courier" value="{{ $courier }}">
    <input type="hidden" name="truck_number" value="{{ $truck_number }}">
    <input type="hidden" name="dr_si" value="{{ $dr_si }}">
    <input type="hidden" name="purchase_id" value="{{ $purchase_id }}">
    <input type="hidden" name="sku_type[{{ $data->sku->id }}]" value="{{ $data->sku->sku_type }}">
    <input type="hidden" name="invoice_date" value="{{ $invoice_date }}">
    <input type="hidden" name="scanned_by" value="{{ $draft[0]->user_id }}">
    <input type="hidden" name="draft_session_id" value="{{ $draft[0]->session_id }}">
    <br />
    <button class="btn btn-sm float-right btn-info">Proceed Final Summary</button>
</form>




<script>
    $('.select2').select2()
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })


    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }


    $("#receive_order_data_final_summary").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "receive_order_data_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);

                // $('.loading').hide();
                // $("#principal").val('').trigger('change');
                // $('#van_selling_transaction_show_sku_page').hide();
                $('#show_data_final_summary').html(data);
                // $('#hide_if_trigger').show();
            },
        });
    }));

    // function generate_final_summary() {
    //     var form = document.myform;
    //     var dataString = $(form).serialize();
    //     $('.loading').show();
    //     $.ajax({
    //         type: 'POST',
    //         url: '/receive_order_data_final_summary',
    //         data: dataString,
    //         success: function(data) {

    //             console.log(data);
    //             if (data == 'some of your sku doesnt have expiration date.') {
    //                 Swal.fire(
    //                     'PLEASE REVIEW EXPIRATION DATE',
    //                     'SOME OF YOUR SKU DOESNT HAVE EXPIRATE DATE',
    //                     'error'
    //                 )
    //                 $('.loading').hide();
    //             } else if (data == 'null') {
    //                 Swal.fire(
    //                     'TO PROCEED',
    //                     'SELECT DISCOUNT FIRST, THANK YOU!',
    //                     'error'
    //                 )
    //                 $('.loading').hide();
    //             } else {
    //                 $('.loading').hide();
    //                 $('#show_data_final_summary').html(data);
    //                 // $('#generate_cifpi_button').prop('disabled', true);

    //             }
    //             //           	if (data == 'null') {
    //             //           		Swal.fire(
    //             //   'TO PROCEED',
    //             //   'SELECT DISCOUNT FIRST, THANK YOU!',
    //             //   'error'
    //             // )
    //             //           	}else{
    //             //           		$('.loading').hide();
    //             //            	$('#show_data_final_summary').html(data);  
    //             //            	 // $('#generate_cifpi_button').prop('disabled', true);

    //             //           	}

    //         }
    //     });
    //     return false;
    // }

    $(function() {
        $(".datepicker").datepicker();
        $('.select2').select2()
    });
</script>
