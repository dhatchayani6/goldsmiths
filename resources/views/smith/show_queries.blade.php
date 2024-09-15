<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jewel Queries</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }

        .table-container {
            margin-top: 40px;
        }

        .table th {
            background-color: #007bff;
            color: white;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }
    </style>
</head>

<body>
    <div class="container table-container">
        <h1 class="my-4">User Queries About Jewels</h1>

        @if($queries->isEmpty())
            <p>No queries found.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Submitted On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($queries as $query)
                        <tr>
                            <td>{{ $query->user ? $query->user->name : 'Unknown User' }}</td>
                            <td>{{ $query->user ? $query->user->email : 'No Email' }}</td>
                            <td>{{ $query->message }}</td>
                            <td>{{ $query->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-success btn-accept" data-id="{{ $query->id }}">Accept</button>
                                    <button class="btn btn-danger btn-reject" data-id="{{ $query->id }}">Reject</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle Accept button click
            $(document).on('click', '.btn-accept', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ url('/queries') }}/" + id + "/accept",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Query accepted successfully.');
                            location.reload(); // Refresh the page to reflect changes
                        }
                    },
                    error: function() {
                        alert('Error accepting the query.');
                    }
                });
            });

            // Handle Reject button click
            $(document).on('click', '.btn-reject', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ url('/queries') }}/" + id + "/reject",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Query rejected successfully.');
                            location.reload(); // Refresh the page to reflect changes
                        }
                    },
                    error: function() {
                        alert('Error rejecting the query.');
                    }
                });
            });
        });
    </script>
</body>

</html>