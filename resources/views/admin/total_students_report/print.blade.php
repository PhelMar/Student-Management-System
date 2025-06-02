<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Student Report</title>
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .header { text-align: center; display: flex; justify-content: center; align-items: center; }
        .header img { height: 115px; margin-right: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <img src="/images/lccLogo.png" alt="School Logo">
        <div>
            <h2>Legacy College of Compostela, Inc.</h2>
            <p>Purok 2 Dagohoy St. Poblacion Compostela</p>
            <p>Quality Education Within Reach</p>
            <p>Student Summary Report</p>
        </div>
    </div>

    <table>
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
                    <td class="total">{{ $data['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="total">Overall Total</td>
                <td class="total">{{ $overallTotal }}</td>
            </tr>
        </tfoot>
    </table>

    <script>
        window.onload = function () {
            window.print();
            window.onafterprint = function () {
                window.close();
            };
        };
    </script>
</body>
</html>
