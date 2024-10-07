<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Active Users Report</title>
    <style>
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
            font-size: 11px;
        }
        .table-applicants th, .table-applicants td {
            text-align: left;
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table-applicants th {
            background-color: #f9f9f9;
        }
        .report-info {
            margin-top: 40px;
            font-weight: bold;
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
        .report-info p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: gray;
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
            <div class="report-title">Active Users Report</div>
        </div>
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
                @foreach($employees as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->firstname }} {{ $user->middlename }} {{ $user->lastname }}</td>
                        <td>{{ $user->contact }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->branch->branchname }}</td>
                        <td>{{ $user->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="report-info">
            <p class="prepared-by">Prepared By:</p>
            <h5>{{ Auth::user()->firstname }} {{ Auth::user()->middlename }} {{ Auth::user()->lastname }}</h5>
            <p>{{ Auth::user()->role }}</p>
        </div>
        <div class="printed-info">
            <p style="font-size: 12px; color: gray;">Printed Date: {{ date('F j, Y') }}</p>
            <p style="font-size: 12px; color: gray;">Printed Time: {{ \Carbon\Carbon::now('Asia/Manila')->format('h:i A') }}</p>
        </div>
    </div>
</body>
</html>
