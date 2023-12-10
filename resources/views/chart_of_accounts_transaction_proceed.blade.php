@if ($transaction == 'new_general_ledger')
    <form id="chart_of_accounts_final_summary">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="">General Account Number</label>
                    <input type="number" min="0" class="form-control" required name="general_account_number">
                </div>
            </div>
        </div>
        <div class="form-group">
            <button onclick="removeRow()" type="button" class="float-right btn-sm btn btn-danger">Remove
                Row</button>
            <button type="button" onclick="addRow()" class="float-right btn-sm btn btn-warning"
                style="margin-right:5px;">Add Row</button>

            <br />
        </div>
        <br />
        <table class="table table-striped table-bordered  table-sm" id="myTable">
            <thead>
                <tr>
                    <th style="text-align: center;">Subsidiary Account Name</th>
                </tr>
            </thead>
        </table>
        <input type="hidden" name="first_input" value="{{ $first_input }}">
        <input type="hidden" name="transaction" value="{{ $transaction }}">
        <button class="btn btn-sm float-right btn-info">Proceed</button>
    </form>

    <script>
        function addRow() {
            var table = document.getElementById("myTable");
            var row = table.insertRow(1);
            var cell1 = row.insertCell(0);
            cell1.innerHTML = "<input class='form-control' name='second_input[]' style='text-transform:uppercase'>";
        }

        function removeRow() {
            document.getElementById("myTable").deleteRow(1);
        }


        $("#chart_of_accounts_final_summary").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "chart_of_accounts_final_summary",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    $('#chart_of_accounts_final_summary_page').html(data);
                    // if (data == 'no_input') {
                    //     $('#loader').hide();
                    //     Swal.fire(
                    //         'CANNOT PROCEED!',
                    //         'PRINCIPAL AND UOM FIELD ARE NEEDED',
                    //         'error'
                    //     )
                    // } else {
                    //     $('#loader').hide();
                    //     $('#show_input').html(data);
                    // }
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
@else
    <form id="chart_of_accounts_final_summary">
        <div class="form-group">
            <button onclick="removeRow()" type="button" class="float-right btn-sm btn btn-danger">Remove
                Row</button>
            <button type="button" onclick="addRow()" class="float-right btn-sm btn btn-warning"
                style="margin-right:5px;">Add Row</button>

            <br />
        </div>
        <br />
        <table class="table table-striped table-bordered  table-sm" id="myTable">
            <thead>
                <tr>
                    <th style="text-align: center;">Subsidiary Account Name</th>
                </tr>
            </thead>
        </table>
        <input type="hidden" name="first_input" value="{{ $first_input }}">
        <input type="hidden" name="transaction" value="{{ $transaction }}">
        <button class="btn btn-sm float-right btn-info">Proceed</button>
    </form>

    <script>
        function addRow() {
            var table = document.getElementById("myTable");
            var row = table.insertRow(1);
            var cell1 = row.insertCell(0);
            cell1.innerHTML = "<input class='form-control' name='second_input[]' style='text-transform:uppercase'>";
        }

        function removeRow() {
            document.getElementById("myTable").deleteRow(1);
        }



        $("#chart_of_accounts_final_summary").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "chart_of_accounts_final_summary",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    $('#chart_of_accounts_final_summary_page').html(data);
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
@endif
