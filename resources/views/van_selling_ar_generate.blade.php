<div class="col-md-12">
    <form id="van_selling_ar_proceed_to_final_summary">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>RUNNING BALANCE</th>
                    <th>ACTUAL STOCKS ON HAND</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input required type="text" name="running_balance" class="form-control"
                            onkeypress="return isNumberKey(event)">
                    </td>
                    <td><input required type="text" name="actual_stocks_on_hand" class="form-control"
                            onkeypress="return isNumberKey(event)">
                    </td>

                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                        <input type="hidden" name="store_name" value="{{ $store_name }}">
                        <button type="submit" class="btn btn-sm float-right btn-info">Proceed</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>

<script type="text/javascript">
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $("#van_selling_ar_proceed_to_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            url: "van_selling_ar_proceed_to_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                if (data == 'no_data_found') {
                    $('.loading').hide();
                    Swal.fire(
                        'No Data Found!!',
                        'Cannot Proceed!',
                        'error'
                    )
                } else {
                    $('.loading').hide();
                    $('#van_selling_ar_proceed_to_final_summary_page').html(data);
                }
            },
        });
    }));
</script>
