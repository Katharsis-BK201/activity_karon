<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Edit Student</h1>
        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label>First Name:</label>
            <input type="text" name="first_name" value="{{ $student->first_name }}" >
            <label>Last Name:</label>
            <input type="text" name="last_name" value="{{ $student->last_name }}" >
            <label>Address:</label>
            <input type="text" name="address" value="{{ $student->address }}">
            <button type="submit">Update Student</button>
        </form>
    <a href="{{ route('students.index') }}">Back</a>

</body>
</html>