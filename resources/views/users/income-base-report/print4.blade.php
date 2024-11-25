<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print IPS Students</title>
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}">
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
            <p>Above 30K Income Reports</p>
        </div>
    </div>
    <table border="1">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Year</th>
                <th>School Year</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($above30k as $student)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$student->first_name}} {{$student->last_name}}</td>
                <td>{{$student->course->course_name}}</td>
                <td>{{$student->year->year_name}}</td>
                <td>{{$student->school_year->school_year_name}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" class="total">Total Income Above 30k </td>
                <td class="total">{{ $above30k->count() }}</td>
            </tr>
        </tbody>
    </table>
    <script>
        // Trigger the browser's print dialog on page load
        window.onload = function() {
            window.print();
            // Redirect back to the main page after printing
            window.onafterprint = function() {
                window.close();
            };
        };
    </script>
</body>

</html>