<form id="invoice_out_final_summary">
    @csrf
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th>Sales Rep</th>
                    <th>Customer</th>
                    <th style="text-align: center;"><input type="checkbox" onclick="toggle(this);" class="big-checkbox" />
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice_draft as $data)
                    <tr>
                        <td>{{ $data->sales_representative }}</td>
                        <td>{{ $data->customer }}</td>
                        <td>
                            <center><input type="checkbox" name="checkbox_entry[]" value="{{ $data->customer }}"
                                    class="big-checkbox" /></center>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br />
    <input type="hidden" name="sales_representative" value="{{ $sales_representative }}">
    <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
</form>

<script>
    function toggle(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $("#invoice_out_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "invoice_out_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'invalid') {
                    Swal.fire(
                        'Cannot Proceed',
                        'Invalid Barcode',
                        'error'
                    )

                    $('#loader').hide();
                } else {
                    $('#confirmed_quantity').val('');
                    $('#barcode').val('');
                    $('#confirmed_quantity').focus();
                    $('#invoice_out_final_summary_page').html(data);

                    $('#loader').hide();
                }
            },
            error: function(error) {
                
                $('#loader').hide();
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )

            }
        });
    }));
</script>
