@if ($disbursement == 'payment to principal')
    <label for="">Principal:</label>
    <select name="principal_id" class="form-control" required>
        <option value="" default>Select</option>
        @foreach ($principal as $data)
            <option value="{{ $data->id }}">{{ $data->principal }}</option>
        @endforeach
    </select>
@endif
