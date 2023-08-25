<label for="">Location</label>
<select name="location_details_id" class="form-control" required>
    <option value="" default>Select</option>
    @foreach ($location_details as $item)
        <option value="{{ $item->id }}">{{ $item->barangay }}</option>
    @endforeach
</select>