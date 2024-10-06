<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Query Status</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #000000 !important;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            color: black !important;
        }

        .navbar-light .navbar-brand {
            color: #000000 !important;
        }
    </style>
</head>

<body>
    @include('user.navbar')

    <div class="container mt-5">
        <h1 class="mb-4">User Queries Status</h1>
w
        <table class="table table-bordered" id="queriesTable">
            <thead>
                <tr>
                    <th>USER ID</th>
                    <th>Message</th>
                    <th>Jewel Id</th>

                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if($userQueries->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">No queries found for the user.</td>
                    </tr>
                @else
                    @foreach($userQueries as $query)
                        <tr>
                            <td>{{ $query->user_id }}</td>
                            <td>{{$query->message}}</td>
                            <td>{{$query->jewel_id}}</td>
                            <td>{{ $query->status }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    @include('home.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#refreshQueries').click(function () {
                $.ajax({
                    url: "{{ url('userqueries')  }}" + id, // Adjust to your route
                    method: 'GET',
                    success: function (response) {
                        const queriesTableBody = $('#queriesTable tbody');
                        queriesTableBody.empty(); // Clear the existing table body

                        if (response.data.length === 0) {
                            queriesTableBody.append('<tr><td colspan="4" class="text-center">No queries found for the user.</td></tr>');
                        } else {
                            response.data.forEach(query => {
                                queriesTableBody.append(`
                                    <tr>
                                        <td>${query.user_id}</td>
                                        <td>${query.jewel_id}</td>
                                        <td>${query.query}</td>
                                        <td>${query.status}</td>
                                    </tr>
                                `);
                            });
                        }
                    },
                    error: function () {
                        alert('Error fetching queries. Please try again later.');
                    }
                });
            });
        });
    </script>
</body>

</html>