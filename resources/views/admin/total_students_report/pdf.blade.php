<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Students Report</title>
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
            <p>Total Students Report</p>
        </div>
    </div>

    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Course</th>
            <th>1st Year</th>
            <th>2nd Year</th>
            <th>3rd Year</th>
            <th>4th Year</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($report as $course => $data)
            <tr>
                <td>{{ $course }}</td>
                <td>{{ $data['1st Year'] ?? 0 }}</td>
                <td>{{ $data['2nd Year'] ?? 0 }}</td>
                <td>{{ $data['3rd Year'] ?? 0 }}</td>
                <td>{{ $data['4th Year'] ?? 0 }}</td>
                <td><strong>{{ $data['total'] }}</strong></td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-end"><strong>Overall Total</strong></td>
            <td><strong>{{ $overallTotal }}</strong></td>
        </tr>
    </tfoot>
</table>
</body>
</html>
