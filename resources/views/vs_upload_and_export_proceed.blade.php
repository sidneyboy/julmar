{{-- <form action="{{ route('vs_upload_and_export_proceed_upload') }}" method="post" enctype="multipart/form-data"> --}}
<form id="vs_upload_and_export_proceed_upload">
    @csrf

    <label>Upload Customer Data</label>
    <input type="file" class="form-control" required name="customer_csv_file">
    <br />
    <button class="btn btn-success btn-sm float-right">Upload Customer Data</button>

</form>


<script>
    $("#vs_upload_and_export_proceed_upload").on('submit', (function(e) {
        e.preventDefault();
         $('#loader').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "vs_upload_and_export_proceed_upload",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                // Swal.fire({
                //     position: 'top-end',
                //     icon: 'success',
                //     title: 'Your work has been saved',
                //     showConfirmButton: false,
                //     timer: 1500
                // });

                // location.reload();
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
