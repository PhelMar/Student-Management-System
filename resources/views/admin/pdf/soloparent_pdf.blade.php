<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soloparent Students List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin: 0;
            /* Remove default margin for header */
            padding: 10px 0;
            /* Add a small amount of padding for spacing */
            display: flex;
            /* Use flexbox to align logo and text */
            justify-content: center;
            /* Center content horizontally */
            align-items: center;
            /* Vertically align items */
        }

        .header img {
            height: 85px;
            width: auto;
            margin-right: 15px;
            /* Space between logo and text */
        }

        h2 {
            margin: 5px 0;
            padding: 0;
        }

        p {
            margin: 2px 0;
            padding: 0;
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
        <img src="{{ public_path('images/lccLogo.png') }}" alt="School Logo"> <!-- School logo -->
        <div>
            <h2>Legacy College of Compostela, Inc.</h2>
            <p>Purok 2 Dagohoy St. Poblacion Compostela</p>
            <p>Quality Education Within Reach</p>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>LAST NAME</th>
                <th>FIRST NAME</th>
                <th>COURSE</th>
                <th>YEAR LEVEL</th>
                <th>SEMESTER</th>
                <th>SCHOOL YEAR</th>
            </tr>
        </thead>
        <tbody>
            @foreach($soloparentData as $soloparentdata)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $soloparentdata->last_name }}</td>
                <td>{{ $soloparentdata->first_name }}</td>
                <td>{{ $soloparentdata->course->course_name }}</td>
                <td>{{ $soloparentdata->year->year_name }}</td>
                <td>{{ $soloparentdata->semester->semester_name }}</td>
                <td>{{ $soloparentdata->school_year->school_year_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>