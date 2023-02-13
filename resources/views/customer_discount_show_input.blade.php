	<div class="row">
		@for ($i=0; $i < $number_of_discounts; $i++)
		<div class="col-md-3">
			<label>Discount # {{ $i + 1 }}</label>
			<input type="text" class="currency-default" name="customer_discount[]" required value="0" style="display: block;
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
		</div>
		@endfor
	</div>

    <script type="text/javascript">
		$('[class=currency-default]').maskNumber();
		$('[class=currency-data-attributes]').maskNumber();
		$('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
		$('[class=integer-default]').maskNumber({integer: true});
		$('[class=integer-data-attribute]').maskNumber({integer: true});
		$('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});
    </script>