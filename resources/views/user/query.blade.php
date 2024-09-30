<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Query Status</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h1>User Queries Status</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Query</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($userQueries as $query)
            <tr>
                <td>{{ $query->id }}</td>
                <td>{{ $query->query_text }}</td> <!-- Assuming the column for query is `query_text` -->
                <td>{{ $query->status }}</td> <!-- Assuming there's a `status` column -->
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
