@if ($transaction == 'new_general_ledger')
    <form id="chart_of_accounts_save">
        @csrf
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Account Number</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($second_input); $i++)
                    <tr>
                        <td style="text-transform: uppercase">{{ $second_input[$i] }}
                            <input type="hidden" value="{{ $second_input[$i] }}" name="subsidiary_ledger_account_name[]">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="{{ $general_account_number + $i + 1 }}"
                                name="subsidiary_ledger_account_number[]">
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <input type="hidden" name="transaction" value="{{ $transaction }}">
        <input type="hidden" name="general_ledger_account_name" value="{{ $first_input }}">
        <input type="hidden" name="general_ledger_account_number" value="{{ $general_account_number }}">
        <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
    </form>

    <script>
        $("#chart_of_accounts_save").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "chart_of_accounts_save",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    location.reload();

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
    <form id="chart_of_accounts_save">
        @csrf

        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Account Number</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($second_input); $i++)
                    <tr>
                        <td style="text-transform: uppercase">{{ $second_input[$i] }}
                            <input type="hidden" value="{{ $second_input[$i] }}"
                                name="subsidiary_ledger_account_name[]">
                        </td>
                        <td>
                            <input type="text" class="form-control"
                                value="{{ $fetch_chart_of_account->account_number + $i + 1 }}"
                                name="subsidiary_ledger_account_number[]">
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <input type="hidden" name="chart_account_id" value="{{ $fetch_chart_of_account->chart_of_accounts_id }}">
        <input type="hidden" name="transaction" value="{{ $transaction }}">
        <input type="hidden" name="general_ledger_account_name" value="{{ $first_input }}">
        <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
    </form>

    <script>
        $("#chart_of_accounts_save").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "chart_of_accounts_save",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    location.reload();

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
