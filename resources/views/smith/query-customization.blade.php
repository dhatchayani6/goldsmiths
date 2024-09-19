<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smith User Queries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
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

        th,
        td {
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
            background-color: #4CAF50;
        }

        .reject-btn {
            background-color: #f44336;
        }

        .user-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .jewel-image {
            height: 100px;
            width: auto;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 24px;
            }

            th,
            td {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>User Queries</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Query</th>
                    <th>User ID</th>
                    <th>User Image</th>
                    <th>Jewel Image</th>
                    <th>Action</th>
                    <th>Status</th>
                    <th>Customize Payment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userQueries as $query)
                    <tr>
                        <td>{{ $query->id }}</td>
                        <td>{{ $query->query }}</td>
                        <td>{{ $query->user_id }}</td>
                        <td>
                            <img src="{{ $query->image_url }}" alt="User Image" class="user-image">
                        </td>
                        <td>
                            @if($query->jewel && $query->jewel->image_url)
                                <img src="{{ asset('storage/' . $query->jewel->image_url) }}" alt="{{ $query->jewel->name }}"
                                     class="jewel-image img-thumbnail">
                            @else
                                <p>No Jewel Image</p>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-success accept-btn">Accept</button>
                            <button class="btn btn-danger reject-btn">Reject</button>
                        </td>
                        <td>{{ $query->status }}</td>
                        <td>
                            @if($query->status === 'accepted')
                                <button class="btn btn-primary customize-btn" 
                                        data-query-id="{{ $query->id }}" 
                                        data-product-id="{{ $query->jewel_id }}" 
                                        data-product-image="{{$query->image_url}}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#customizePaymentModal">Customize Payment</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="customizePaymentModal" tabindex="-1" aria-labelledby="customizePaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customizePaymentModalLabel">Customize Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="customizePaymentForm">
                        <input type="hidden" name="query_id" id="query_id" value="">
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Product ID</label>
                            <input type="text" class="form-control" id="product_id" name="product_id" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="product_image" class="form-label">Product Image</label>
                            <img id="product_image" class="img-thumbnail" style="width: 100%; height: auto;">
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Show modal with query ID and product details
            $('.customize-btn').click(function () {
                var queryId = $(this).data('query-id');
                var productName = $(this).data('product-name');
                var productId = $(this).data('product-id');
                var productImage = $(this).data('product-image');

                $('#query_id').val(queryId);
                $('#product_name').val(productName);
                $('#product_id').val(productId);
                $('#product_image').attr('src', productImage);
            });

            // Submit customize payment form
            $('#customizePaymentForm').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '/query/customize-payment', // Update with the correct route
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });

            // Accept button click event
            $('.btn-success').click(function () {
                var queryId = $(this).closest('tr').find('td:first').text();
                $.ajax({
                    url: '/query/accept/' + queryId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });

            // Reject button click event
            $('.btn-danger').click(function () {
                var queryId = $(this).closest('tr').find('td:first').text();
                $.ajax({
                    url: '/query/reject/' + queryId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>
