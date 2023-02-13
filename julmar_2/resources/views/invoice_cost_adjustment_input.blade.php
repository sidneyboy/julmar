<form class="myform" name="myform" id="myform">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th style="text-align: center;">Code</th>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">UOM</th>
                <th style="text-align: center;">Net QTR Received</th>
                <th style="text-align: center;">Invoice Cost</th>
                <th style="text-align: center;">Adjusted Unit Cost</th>
                <th style="text-align: center;"><input type="checkbox" onclick="toggle(this);"  class="big-checkbox"/></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sku_add_details as $data)
            <tr>
                <td style="text-transform: uppercase;">{{ $data->sku->sku_code }}</td>
                <td style="text-transform: uppercase;">{{ $data->sku->description }}</td>
                <td style="text-transform: uppercase;">{{ $data->sku->unit_of_measurement }}</td>
                <td style="text-align: center;">{{ $quantity = $data->quantity_per_sku - $data->quantity_return_per_sku }}</td>
                <td style="text-align: right;">
                    {{ number_format($data->unit_cost_per_sku,2,".",",") }}
                    <input type="hidden" name="invoice_cost[{{ $data->sku->id }}]" value="{{ $data->unit_cost_per_sku }}">
                </td>
                <td><input type="text" class="currency-default" name="unit_cost_adjustment[{{ $data->sku->id }}]" style="width:100%;"></td>
                <td>
                    <center>
                    <input type="checkbox"  name="checkbox_entry[]" value="{{ $data->sku->id }}" class="big-checkbox" />
                    </center>
                    <input type="hidden" value="{{ $data->sku->description }}" name="description[{{ $data->sku->id }}]">
                    <input type="hidden" value="{{ $data->sku->unit_of_measurement }}" name="unit_of_measurement[{{ $data->sku->id }}]">
                    <input type="hidden" value="{{ $quantity }}" name="quantity[{{ $data->sku->id }}]">
                    <input type="hidden" value="{{ $data->sku->sku_code }}" name="code[{{ $data->sku->id }}]">
                    <input type="hidden" value="{{ $data->discounts }}" name="discounts[{{ $data->sku->id }}]">
                    <input type="hidden" value="{{ $data->unit_cost_per_sku }}" name="last_unit_cost[{{ $data->sku->id }}]">
                    <input type="hidden" value="{{ $data->sku->category_id }}" name="category_id[{{ $data->sku->id }}]">
                    <input type="hidden" value="{{ $data->sku->principal_id }}" name="principal_id[{{ $data->sku->id }}]">
                    <input type="hidden" value="{{ $data->sku->sku_type }}" name="sku_type[{{ $data->sku->id }}]">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <input type="hidden" value="{{ $received_id }}" name="received_id">
    <input type="hidden" value="{{ $principal_name }}" name="principal_name">
    <input type="hidden" value="{{ $principal_id }}" name="invoice_cost_principal_id">
    <input type="hidden" value="{{ $purchase_id }}" name="purchase_id">
    <input type="hidden" value="{{ $dr_si }}" name="dr_si">
    
    <label>Particulars</label>
    <input type="text" class="form-control" name="particulars" required><br />
</form>
<button class="float-right btn btn-info btn-flat btn-sm btn-block" type="button" onclick="return generate()" style="font-weight: bold;">GENERATE DATA</button>
<script>
function toggle(source) {
var checkboxes = document.querySelectorAll('input[type="checkbox"]');
for (var i = 0; i < checkboxes.length; i++) {
if (checkboxes[i] != source)
checkboxes[i].checked = source.checked;
}
}
$('[class=currency-default]').maskNumber();
$('[class=currency-data-attributes]').maskNumber();
$('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
$('[class=integer-default]').maskNumber({integer: true});
$('[class=integer-data-attribute]').maskNumber({integer: true});
$('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});
function generate() {
var form = document.myform;
var dataString = $(form).serialize();
//$('.loading').show();
$.ajax({
type:'POST',
url:'/invoice_cost_adjustments_show_summary',
data: dataString,
success: function(data){


    if(data == 'no unit_cost'){
        toastr.warning('INPUT UNIT COST ADJUSTMENT AMOUNT ON SELECTED SKU')
        $('.loading').hide();
        $('#show_invoice_cost_adjustments_summary').hide();
    }else if(data == 'no particulars'){
         toastr.warning('PARTICULARS FIELD NEEDED')
        $('.loading').hide();
        $('#show_invoice_cost_adjustments_summary').hide();
    }else{
        toastr.info('PROCEEDING');
        $('.loading').hide();
        $('#show_invoice_cost_adjustments_summary').show();
        $('#show_invoice_cost_adjustments_summary').html(data);
        
    }

}
});
return false;
}
</script>