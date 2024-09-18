<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Queries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #3498db;
            margin-bottom: 20px;
            font-size: 28px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
            transition: background-color 0.3s;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #e1f5fe;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            font-size: 14px;
        }
        .accept-btn {
            background-color: #4CAF50; /* Green */
        }
        .reject-btn {
            background-color: #f44336; /* Red */
        }
        .user-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        .jewel-image {
            height: 100px; /* Adjust height */
            width: auto; /* Maintain aspect ratio */
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 24px;
            }
            th, td {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Queries</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Query</th>
                    <th>User ID</th>
                    <th>User Image</th>
                    <th>Jewel Image</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userQueries as $query)
                    <tr>
                        <td>{{ $query->id }}</td>
                        <td>{{ $query->query }}</td>
                        <td>{{ $query->user_id }}</td>
                        <td>
                            @if($query->user && $query->user->image)
                                <img src="{{ asset('storage/' . $query->user->image) }}" alt="User Image" class="user-image">
                            @else
                                <img src="{{ asset('images/default.png') }}" alt="Default Image" class="user-image">
                            @endif
                        </td>
                        <td>
                            @if($query->jewel && $query->jewel->image_url) <!-- Check if the jewel and image exist -->
                                <img src="{{ asset('storage/' . $query->jewel->image_url) }}" alt="{{ $query->jewel->name }}" class="jewel-image img-thumbnail">
                            @else
                                <p>No Jewel Image</p>
                            @endif
                        </td>
                        <td>{{ $query->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $query->updated_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
