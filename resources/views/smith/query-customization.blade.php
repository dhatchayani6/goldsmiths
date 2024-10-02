<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smith User Queries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
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
    @include('smith.navabr')

    <div class="container mt-5">
        <h1>Customize User Queries</h1>
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
                <tr data-query-id="{{ $query->id }}">
                    <td>{{ $query->id }}</td>
                    <td>{{ $query->query }}</td>
                    <td>{{ $query->user_id }}</td>
                    <td>
                        <img src="{{ $query->image_url }}" alt="User Image" class="user-image">
                    </td>
                    <td>
                        @if($query->jewel && $query->jewel->image_url)
                        <img src="{{ asset('storage/' . $query->jewel->image_url) }}" alt="{{ $query->jewel->name }}" class="jewel-image img-thumbnail">
                        @else
                        <p>No Jewel Image</p>
                        @endif
                    </td>
                    <td>
                        @if($query->status === 'pending')
                        <button class="btn accept-btn">Accept</button>
                        <button class="btn reject-btn">Reject</button>
                        @elseif($query->status === 'accepted')
                        <button class="btn accept-btn" disabled>Accepted</button>
                        @else
                        <button class="btn reject-btn" disabled>Rejected</button>
                        @endif
                    </td>
                    <td>{{ $query->status }}</td>
                    <td>
                        @if($query->status === 'accepted')
                        <button class="btn btn-primary customize-btn" data-query-id="{{ $query->id }}" data-product-id="{{ $query->jewel_id }}" data-product-image="{{ $query->image_url }}" data-jewel-id="{{ $query->jewel_id }}" data-user-id="{{ $query->user_id }}" data-customer-name="{{ $query->customer_name }}" data-bs-toggle="modal" data-bs-target="#customizePaymentModal">Customize Payment</button>
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
                        @csrf
                        <input type="hidden" name="jewel_id" id="jewel_id" value="">
                        <input type="hidden" name="user_id" id="user_id" value="">

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
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="size">Size</label>
                                <input type="text" class="form-control" id="size" name="size" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control" id="amount" name="total_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
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
        $(document).ready(function() {
            // Set up AJAX with CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Accept button click event
            $('.accept-btn').click(function() {
                var row = $(this).closest('tr');
                var queryId = row.data('query-id');
                var button = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/query/accept/' + queryId,
                    success: function(response) {
                        button.prop('disabled', true).text('Accepted');
                        row.find('.reject-btn').prop('disabled', true);
                        row.find('td:last').html('<button class="btn btn-primary customize-btn" data-query-id="' + queryId + '" data-product-id="' + response.jewel_id + '" data-product-image="' + response.image_url + '" data-jewel-id="' + response.jewel_id + '" data-user-id="' + response.user_id + '" data-customer-name="' + response.customer_name + '" data-bs-toggle="modal" data-bs-target="#customizePaymentModal">Customize Payment</button>');
                        row.find('td:nth-last-child(2)').text('Accepted');
                    },
                    error: function(xhr) {
                        alert('Error accepting query.');
                    }
                });
            });

            // Reject button click event
            $('.reject-btn').click(function() {
                var row = $(this).closest('tr');
                var queryId = row.data('query-id');
                var button = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/query/reject/' + queryId,
                    success: function() {
                        button.prop('disabled', true).text('Rejected');
                        row.find('.accept-btn').prop('disabled', true);
                        row.find('td:last').text('Rejected');
                    },
                    error: function(xhr) {
                        alert('Error rejecting query.');
                    }
                });
            });

            // Open customize payment modal
            $('.customize-btn').click(function() {
                var queryId = $(this).data('query-id');
                var productId = $(this).data('product-id');
                var productImage = $(this).data('product-image');
                var jewelId = $(this).data('jewel-id');
                var userId = $(this).data('user-id');
                var customerName = $(this).data('customer-name');

                $('#jewel_id').val(jewelId);
                $('#user_id').val(userId);
                $('#product_id').val(productId);
                $('#product_name').val($(this).text());
                $('#product_image').attr('src', productImage);

                // Reset form fields
                $('#size').val('');
                $('#quantity').val('');
                $('#amount').val('');
                $('#mobile_number').val('');
                $('#customer_name').val(customerName);
            });

            // Handle form submission
            $('#customizePaymentForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '/query/customize-payment',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Payment customized successfully.');
                        $('#customizePaymentModal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Error customizing payment.');
                    }
                });
            });
        });
    </script>
</body>

</html>
