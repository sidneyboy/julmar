<form action="{{ route('vs_upload_and_export_proceed_upload') }}" method="post" enctype="multipart/form-data">
    @csrf

    <label>Upload Customer Data</label>
    <input type="file" class="form-control" required name="customer_csv_file">
    <br />
    <button class="btn btn-success btn-block">UPLOAD</button>

</form>
