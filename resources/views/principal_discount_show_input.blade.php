<form id="save_discount_form">
    @csrf
    <div class="row">
        <input type="hidden" name="number_of_discounts" value="{{ $number_of_discounts }}">
        <input type="hidden" name="principal_id" value="{{ $principal_id }}">
        <div class="col-md-6">
            <div class="form-group">
                <label>Bo Allowance Discount:</label>
                <input type="text" name="bo_allowance_discount" placeholder="BO Allowance Discount"
                    onkeypress="return isNumberKey(event)" class="form-control" 
                    required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Cash w/ Order Discount:</label>
                <input type="text" name="cash_with_order_discount" placeholder="Cash with order discount"
                     class="form-control" onkeypress="return isNumberKey(event)"
                    required>
            </div>
        </div>
        @if ($number_of_discounts == 1)
            @for ($i = 0; $i < $number_of_discounts; $i++)
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Discount_name:</label>
                        <input type="text" name="discount_name[]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Discount:</label>
                        <input type="text" name="discount_rate[]" class="form-control"
                            onkeypress="return isNumberKey(event)" required>
                    </div>
                </div>
            @endfor
        @elseif($number_of_discounts == 2)
            @for ($i = 0; $i < $number_of_discounts; $i++)
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Discount_name:</label>
                        <input type="text" name="discount_name[]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Discount:</label>
                        <input type="text" name="discount_rate[]" class="form-control"
                            onkeypress="return isNumberKey(event)" required>
                    </div>
                </div>
            @endfor
        @elseif($number_of_discounts == 3)
            @for ($i = 0; $i < $number_of_discounts; $i++)
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Discount_name:</label>
                        <input type="text" name="discount_name[]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Discount:</label>
                        <input type="text" name="discount_rate[]" class="form-control"
                            onkeypress="return isNumberKey(event)" required>
                    </div>
                </div>
            @endfor
        @elseif($number_of_discounts >= 4)
            @for ($i = 0; $i < $number_of_discounts; $i++)
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Discount_name:</label>
                        <input type="text" name="discount_name[]"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Discount:</label>
                        <input type="text" name="discount_rate[]" class="form-control"
                            onkeypress="return isNumberKey(event)" required>
                    </div>
                </div>
            @endfor
        @endif
        <div class="col-md-12">
            <div class="form-group">
                <button type="submit" class="btn btn-success float-right btn-sm">Submit New Principal Discount</button>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }


    $("#save_discount_form").on('submit', (function(e) {
        e.preventDefault();

        $('.loading').show();
        $.ajax({
            url: "principal_discount_save",
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
                    $('.loading').hide();
                }
            },
        });
    }));

    // $('[class=form-control] onkeypress="return isNumberKey(event)"').maskNumber();
    // $('[class=currency-data-attributes]').maskNumber();
    // $('[class=currency-configuration]').maskNumber({
    //     decimal: '_',
    //     thousands: '*'
    // });
    // $('[class=integer-default]').maskNumber({
    //     integer: true
    // });
    // $('[class=integer-data-attribute]').maskNumber({
    //     integer: true
    // });
    // $('[class=integer-configuration]').maskNumber({
    //     integer: true,
    //     thousands: '_'
    // });
</script>
