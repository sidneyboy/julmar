

<div class="table table-responsive">
	<form class="myform" id="myform" name="myform">
		<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th colspan="5" style="font-weight: bold;text-align: center;color:blue;">SKU PRICE UPDATE</th>
			</tr>
			<tr>
				<th style="text-align: center;">Code</th>
				<th style="text-align: center;">Description</th>
				<th style="text-align: center;">Price 1</th>
				<th style="text-align: center;">Price 2</th>
				<th style="text-align: center;">Price 3</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sku_price as $price)
				<tr>
					<td style="text-transform: uppercase;text-align: center;">{{ $price[0]->sku->sku_code }}</td>
					<td style="text-transform: uppercase;text-align: center;">{{ $price[0]->sku->description }}</td>
					<td><input type="text" style="text-align: right;display: block;
              width: 50%;
              height: 34px;
              padding: 6px 12px;
              font-size: 14px;
              line-height: 1.42857143;
              color: red;
              background-color: #fff;
              background-image: none;
              border: 1px solid #ccc;
              border-radius: 4px 4px 4px 4px;
              -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
              box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
              -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
              -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
              transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;width:100%;" name="price_1[{{ $price[0]->sku_id }}]" value="{{ $price[0]->price_1 }}" class="currency-default" ></td>
					<td><input type="text" style="text-align: right;display: block;
              width: 50%;
              height: 34px;
              padding: 6px 12px;
              font-size: 14px;
              line-height: 1.42857143;
              color: red;
              background-color: #fff;
              background-image: none;
              border: 1px solid #ccc;
              border-radius: 4px 4px 4px 4px;
              -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
              box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
              -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
              -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
              transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;width:100%;" name="price_2[{{ $price[0]->sku_id }}]" value="{{ $price[0]->price_2 }}" class="currency-default" ></td>
					<td><input type="text" style="text-align: right;display: block;
              width: 50%;
              height: 34px;
              padding: 6px 12px;
              font-size: 14px;
              line-height: 1.42857143;
              color: red;
              background-color: #fff;
              background-image: none;
              border: 1px solid #ccc;
              border-radius: 4px 4px 4px 4px;
              -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
              box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
              -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
              -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
              transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;width:100%;" name="price_3[{{ $price[0]->sku_id }}]" value="{{ $price[0]->price_3 }}" class="currency-default" ></td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<button class="btn btn-success btn-block btn-flat" type="button" onclick="return update_price_save()" style="width:100%;">UPDATE PRICE</button>
	</form>
</div>

<script type="text/javascript">
	$('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});
</script>