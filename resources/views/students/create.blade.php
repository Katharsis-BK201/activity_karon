<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <h1>Add Students</h1>
    <form>
        @csrf
        <label>First Name:</label>
        <input type="text" name="first_name" >
        <label>Last Name:</label>
        <input type="text" name="last_name" >
        <label>Address:</label>
        <input type="text" name="address">
        <button type="submit" id = "AddStudents">Add Student</button>
    </form>
</body>
<script>
    $(document).ready(function() {
        $('#AddStudents').click(function(e) {
            e.preventDefault();
            
            // Collect form data
            var first_name = $('input[name="first_name"]').val().trim();
            var last_name = $('input[name="last_name"]').val().trim();
            var address = $('input[name="address"]').val().trim();
            var token = $('meta[name="csrf-token"]').attr('content'); // CSRF Token

            // Validation Check
            const nameRegex = /^[A-Za-z\s]+$/; // Only allows letters and spaces

            if (!first_name || !last_name || !address) {
                Swal.fire({
                    icon: "error",
                    title: "Please fill in all the required fields!",
                    text: "Some information is missing.",
                });
                return;
            }

            if (!nameRegex.test(first_name) || !nameRegex.test(last_name)) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Name!",
                    text: "First name and last name must only contain letters and spaces. Numbers are not allowed.",
                });
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });

            // AJAX Request
            $.ajax({
                type: "POST",
                url: "{{ route('students.store') }}",
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    address: address,
                    _token: token,
                },
                success: function(response) {
                    Swal.fire({
                        title: "Registration Successful!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('students.index') }}";
                        }
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: xhr.responseJSON?.message || "An error occurred while registering the student.",
                    });
                }
            });
        });
    });
</script>


</html>