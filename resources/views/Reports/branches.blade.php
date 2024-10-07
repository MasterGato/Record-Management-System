<!-- resources/views/reports/branches.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Branches Report</title>
    <style>
        /* Add custom styles for the PDF report */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Branches Report</h1>
    <table>
        <thead>
            <tr>
                <th>Branch Name</th>
                <th>Region</th>
                <th>Province</th>
                <th>City</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($branches as $branch)
            <tr>
                <td>{{ $branch->branchname }}</td>
                <td>{{ $branch->region }}</td>
                <td>{{ $branch->province }}</td>
                <td>{{ $branch->city }}</td>
                <td>{{ $branch->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
