<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students List</title>
    <link rel="stylesheet" href="{{asset('assests/css/index.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
</head>
<body>
    <h1>Students List</h1>
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->first_name }}</td>
                <td>{{ $student->last_name }}</td>
                <td>{{ $student->address }}</td>
                <td>
                    <!-- Edit Button -->
                    <form action="{{ route('students.edit', Crypt::encrypt($student->id)) }}" method="get" style="display:inline;">
                        <button type="submit" class="edit">Edit</button>
                    </form>
                    
                    <!-- Delete Button with Data-ID -->
                    <button class="delete" data-id="{{ Crypt::encrypt($student->id) }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('students.create') }}" class="btn btn-primary">Add Students</a>

    <script>
    $(document).ready(function() {
        $('.delete').click(function(e) {
            e.preventDefault();
            const studentId = $(this).data('id');
            const token = $('meta[name="csrf-token"]').attr('content');

            // SweetAlert Confirmation
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform AJAX Request
                    $.ajax({
                        url: `/students/${studentId}`,
                        type: 'POST',
                        data: {
                            _token: token,
                            _method: 'DELETE',
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message || "The student has been deleted.",
                                icon: "success"
                            }).then(() => {
                                location.reload(); // Refresh the page
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: xhr.responseJSON?.message || "An error occurred while deleting the student.",
                            });
                        }
                    });
                }
            });
        });
    });
    </script>
</body>
</html>
