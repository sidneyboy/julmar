<div class="row">
    <div class="col-md-12">
        <select name="beginning_date" class="form-control" required>
            <option value="" default>Select Beginning Date</option>
            @foreach ($ap_ledger_beginning as $data)
                <option
                    value="{{ $data->id }}">{{ date('Y-m-d', strtotime($data->created_at)) }}</option>
            @endforeach
        </select>
    </div>
</div>
