<!DOCTYPE html>

<html>

<head>

    <title>Laravel Sweet Alert Notification</title>

    <link rel="stylesheet" href="css/libs.css" />

    <script src="js/libs.js"></script>

    <link rel="stylesheet" href="css/sweetalert.min.css" />

    <script src="js/sweetalert.min.js"></script>

</head>
<button id="deleteBtn">Delete Buton</button>
<body>
<script type="text/javascript">
    $('#deleteBtn').on('click', function(){
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
    });


</script>




</body>

</html>