<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print 4p's Students</title>
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header img {
            height: 115px;
            margin-right: 15px;
        }

        h2,
        p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="/images/lccLogo.png" alt="School Logo">
        <div>
            <h2>Legacy College of Compostela, Inc.</h2>
            <p>Purok 2 Dagohoy St. Poblacion Compostela</p>
            <p>Quality Education Within Reach</p>
            <p>Course: {{ $courseName }} | Year Level: {{ $yearName }}</p>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>STUDENT'S NAME</th>
                <th>COURSE</th>
                <th>YEAR LEVEL</th>
                <th>SEMESTER</th>
                <th>SCHOOL YEAR</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($studentsData as $record)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $record->student->last_name }}, {{ $record->student->first_name }}</td>
                <td>{{ $record->course->course_name }}</td>
                <td>{{ $record->year->year_name }}</td>
                <td>{{ $record->semester->semester_name }}</td>
                <td>{{ $record->schoolYear->school_year_name }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5" class="total">Total Students</td>
                <td class="total">{{ $studentsData->count() }}</td>
            </tr>
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        };
    </script>
</body>

</html>