@if ($report_type != 'trial_balance')
    <select name="report_selection" class="form-control select2bs4" required>
        <option value=""default>Select</option>
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
