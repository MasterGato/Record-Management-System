<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Active Users Report</title>
    <style>
        /* Include your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header h1 {
            text-align: left;
            font-size: 20px;
            margin: 0;
        }
        .title-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .report-title {
            font-weight: bold;
            font-size: 14px;
        }
        .table-applicants {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px; /* Decrease table font size to 11 */
        }
        .table-applicants th, .table-applicants td {
            text-align: left;
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table-applicants th {
            background-color: #f9f9f9;
        }
        .prepared-by {
            margin: 0;
            font-size: 12px;
            font-weight: bold;
            color: black;
            margin-bottom: 10px;
        }
        .report-info h5 {
            margin: 0;
            font-size: 14px;
            margin-top: 20px;
            text-transform: uppercase;
        }
        .printed-info {
            font-size: 12px;
            color: gray;
            margin: 5px 0 0 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>MMML Recruitment Services Inc.</h1>
            </div>
        </div>
        <div class="title-container">
            <div class="report-title">ACTIVE USERS REPORT</div>
        </div>

        <!-- Table with applicants data -->
        <table class="table-applicants">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Role</th>
                    <th>Branch</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->firstname . ' ' . $employee->middlename . ' ' . $employee->lastname }}</td>
                    <td>{{ $employee->contact }}</td>
                    <td>{{ $employee->role }}</td>
                    <td>{{ $employee->branch->branchname }}</td>
                    <td>{{ $employee->status }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        
        <div class="prepared-by">Prepared By:</div>
        <h5>{{ Auth::user()->firstname . " " . Auth::user()->middlename . " " . Auth::user()->lastname }}</h5>
        <p>{{ Auth::user()->role }}</p>

        <div class="printed-info">
            <p>Printed Date: {{ date('F j, Y') }}</p>
            <p>Printed Time: {{ \Carbon\Carbon::now('Asia/Manila')->format('h:i A') }}</p>
        </div>
    </div>
</body>
</html>
