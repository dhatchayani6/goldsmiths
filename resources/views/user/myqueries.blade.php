<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Custom Queries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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

        .jewel-image {
            height: 100px;
            width: auto;
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
                    <th>Jewel Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($showcustomizationqueries as $customizequeries)
                    <tr>
                        <td>{{ $customizequeries->id }}</td>
                        <td>{{ $customizequeries->query }}</td>
                        <td>{{ $customizequeries->user_id }}</td>
                        <td>
                            <img src="{{ $customizequeries->image_url }}" alt="Image" class="jewel-image">
                        </td>
                        <td>{{ $customizequeries->status }}</td>
                        <td>
                            <button class="btn btn-success purchase-btn" data-id="{{ $customizequeries->id }}" data-jewel-id="{{ $customizequeries->jewel_id }}">Payment</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Purchase Modal -->
    <div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="purchaseModalLabel">Purchase Jewel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="purchaseForm">
                        <input type="hidden" id="jewelId" name="jewelId">
                        <div class="mb-3">
                            <label for="buyerName" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="buyerName" name="buyerName" required>
                        </div>
                        <div class="mb-3">
                            <label for="buyerEmail" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="buyerEmail" name="buyerEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="buyerAddress" class="form-label">Shipping Address</label>
                            <textarea class="form-control" id="buyerAddress" name="buyerAddress" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitPurchase">Submit Purchase</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Purchase button click event
            $('.purchase-btn').click(function () {
                var jewelId = $(this).data('jewel-id');
                $('#jewelId').val(jewelId); // Set jewel ID in hidden field
                $('#purchaseModal').modal('show'); // Show the modal
            });

            // Submit purchase form
            $('#submitPurchase').click(function () {
                var formData = $('#purchaseForm').serialize(); // Serialize the form data
                $.ajax({
                    url: '/query/purchase/' + $('#jewelId').val(), // Endpoint for purchase
                    type: 'POST',
                    data: formData + '&_token={{ csrf_token() }}', // Include CSRF token for security
                    success: function (response) {
                        alert(response.message); // Notify user of success
                        $('#purchaseModal').modal('hide'); // Hide the modal
                        location.reload(); // Reload the page to see updates
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseText); // Notify user of error
                    }
                });
            });
        });
    </script>
</body>

</html>
