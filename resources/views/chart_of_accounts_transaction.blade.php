@if ($transaction == 'new_general_ledger')
    <label for="">New Chart of Account</label>
    <input type="text" style="text-transform: uppercase" name="first_input" class="form-control" required>
@elseif($transaction == 'insert_subsidiary_ledger')
    <label for="">Chart of Account</label>
    <select name="first_input" class="form-control select2bs4" style="width:100%;" required>
        <option value="" default>Select</option>
        @foreach ($chart_of_accounts as $data)
            <option value="{{ $data->id }}">{{ $data->account_name }}</option>
        @endforeach
    </select>
@endif

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
