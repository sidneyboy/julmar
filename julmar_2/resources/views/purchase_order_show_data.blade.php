<style>
    #tableCss {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #tableCss td,
    #tableCss th {
        border: 1px solid #ddd;
        padding: 4px;
    }

    #tableCss tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #tableCss tr:hover {
        background-color: #ddd;
    }

    #tableCss th {
        padding-top: 6px;
        padding-bottom: 6px;
        text-align: left;
        background-color: white;
        color: white;
        /* #04b5d4*/
    }
</style>

<center>
    <h4 style="font-family: verdana;">JULMAR COMMERCIAL, INC</h4>
    <h5 style="font-family: verdana;">ST. IGNATIUS KAUSWAGAN, CAGAYAN DE ORO CITY</h5>
    <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
    <h6 style="font-family: verdana;">PO # : {{ $po_id }}</h6>
</center><br />
<div class="container-fluid" style="width:60%">
    <div class="row">
        <div class="col-md-4">
            <h6 style="text-align: center;font-weight: bold;text-transform: uppercase;">Delivery Term:
                {{ $delivery_term }}</h6>
        </div>
        <div class="col-md-4">
            <h6 style="text-align: center;font-weight: bold;text-transform: uppercase;">Payment Term:
                {{ $payment_term }}</h6>
        </div>
        <div class="col-md-4">
            <h6 style="text-align: center;font-weight: bold;text-transform: uppercase;">SO #: {{ $sales_order_number }}
            </h6>
        </div>
    </div>
</div><br />
<form action="#" id="myform" name="myform" class="myform">
    <input type="hidden" name="principal_id" id="principal_id" value="{{ $principal_id }}">
    <input type="hidden" name="payment_term" id="payment_term" value="{{ $payment_term }}">
    <input type="hidden" name="delivery_term" id="delivery_term" value="{{ $delivery_term }}">
    <input type="hidden" name="po_id" id="po_id" value="{{ $po_id }}">
    <input type="hidden" name="particulars" id="particulars" value="{{ $particulars }}">
    <input type="hidden" name="sales_order_number" id="sales_order_number" value="{{ $sales_order_number }}">
    <table id="tableCss">
        <thead>
            <tr>
                <th></th>
                <th style="text-align: center;color:black;">CODE</th>
                <th style="text-align: center;color:black;">TYPE</th>
                <th style="text-align: center;color:black;">DESCRIPTION</th>
                <th style="text-align: center;color:black;">QUANTITY</th>
                <th style="text-align: center;color:black;">UNIT<br />COST</th>

                <th style="text-align: center;color:black;">FINAL UNIT COST</th>
                <th style="text-align: center;color:black;">TOTAL COST</th>
                <th style="text-align: center;color:black;">ACTION</th>
            </tr>
        </thead>
        @if ($cart_total_quantity != 0)

            @foreach ($sku as $data)
                <tr>
                    <td>
                        {{ $data->id }}
                        {{-- <input type="hidden" name="selected_sku" value="{{ $data->id }}"> --}}
                    </td>
                    <td style="text-align: center;text-transform: uppercase;">{{ $data->attributes[0] }}</td>
                    <td style="text-align: center;text-transform: uppercase;">{{ $data->attributes[1] }}</td>
                    <td style="text-align: center;text-transform: uppercase;">{{ $data->name }}</td>
                    <td style="text-align: center;text-transform: uppercase;">
                        <input type="number" style="text-align: center;" class="form-control"
                            name="quantity[{{ $data->id }}]" value="{{ $data->quantity }}">
                        <input type="hidden" name="sku_id[]" value="{{ $data->id }}">

                    </td>
                    <td style="text-align: right;"><input type="hidden" name="unit_cost[{{ $data->id }}]"
                            value="{{ $data->price }}">{{ number_format($data->price, 2, '.', ',') }}</td>
                    <td style="text-align: right;">
                        @php
                            
                            $discounted_final_unit_cost = $data->price - ($data->price * $discount->total_discount) / 100;
                            $sum_discounted_final_unit_cost[] = $discounted_final_unit_cost;
                        @endphp
                        {{ number_format($discounted_final_unit_cost, 2, '.', ',') }}
                        <input type="hidden" name="final_unit_cost[{{ $data->id }}]"
                            value="{{ $discounted_final_unit_cost }}">
                        <input type="hidden" name="discount_rate[{{ $data->id }}]"
                            value="{{ $discount->total_discount }}">
                    </td>
                    <td style="text-align: right;">
                        @php
                            $total_cost = $discounted_final_unit_cost * $data->quantity;
                            $sum_total_cost[] = $total_cost;
                            echo number_format($total_cost, 2, '.', ',');
                        @endphp
                    </td>
                    <td style="text-align: center;text-transform: uppercase;"><button
                            class="btn btn-danger btn-xs btn-flat remove_sku" id="{{ $data->id }}">REMOVE</button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td style="text-align: center;font-weight: bold;" colspan="3">TOTAL QUANTITY</td>
                <td></td>
                <td style="text-align: center;font-weight: bold;">{{ number_format($cart_total_quantity, 2, '.', ',') }}
                </td>
                <td></td>
                <td style="text-align: right;font-weight: bold;">
                    {{ number_format(array_sum($sum_discounted_final_unit_cost), 2, '.', ',') }}</td>
                <td style="text-align: right;font-weight: bold;">
                    {{ number_format(array_sum($sum_total_cost), 2, '.', ',') }}</td>
                <td></td>
            </tr>
        @else
            <tr>
                <td colspan="7" style="color:red;font-weight: bold;text-align: center;">NO DATA FOUND!</td>
            </tr>
        @endif
    </table>
</form>
<br /><br />
<button class="float-right btn btn-success btn-flat btn-xs saveCart" onclick="return save()" style="font-weight: bold;">Submit Purchase Order</button>

</div>


<script>
    $(".remove_sku").click(function(e) {
        e.preventDefault();
        var cart_id = $(this).attr('id');
        var form = document.myform;
        var dataString = $(form).serialize();
        $.ajax({
            type: 'POST',
            url: '/purchase_order_remove_cart',
            data: 'cart_id=' + cart_id + '&dataString=' + dataString,
            success: function(data) {
                console.log(data);
                $('#show_data').html(data);
            }
        });
    });


    function save() {
        var form = document.myform;
        var dataString = $(form).serialize();
        // var showUpdateForm = $('#showUpdateForm');
        //$('.loading').show();
        $.ajax({
            type: 'POST',
            url: '/purchase_order_save',
            data: dataString,
            success: function(data) {
                console.log(data);
                if (data == 'Saved') {
					Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();

                } else {
                   alert('naay error');
                }

            }
        });
        return false;
    }
</script>
