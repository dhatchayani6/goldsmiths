<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customization Queries payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        nav {
            background-color: #ffcc00;
            padding: 0.5rem;
        }

        nav .navbar-brand,
        nav .nav-link {
            color: #000000 !important;
        }

        nav .nav-link:hover {
            color: #000000 !important;
        }

        .jewel-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .footer {
            text-align: center;
            color: #fff;
            bottom: 0;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #6f42c1;
            color: black;
        }

        td {
            color: #333;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    @include('user.navbar')

    <div class="container mt-4 content">
        <h1>Customization Queries payment </h1>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jewel  ID</th>
                    <!-- <th>Query status</th> -->
                    <th>User ID</th>
                    <th>Status</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($showcustomizationqueries as $customizequeries)
                    <tr>
                        <td>{{ $customizequeries->id }}</td>
                        <td>{{ $customizequeries->jewel_id }}</td>
                        <td>{{ $customizequeries->user_id }}</td>
                        <td>{{ $customizequeries->status }}</td>
                        <td>${{ number_format($customizequeries->total_price, 2) }}</td>
                        <td>
                            <button class="btn btn-success purchase-btn" data-id="{{ $customizequeries->id }}"
                                data-jewel-id="{{ $customizequeries->jewel->id }}"
                                data-jewel-name="{{ $customizequeries->jewel->name }}"
                                data-jewel-price="{{ $customizequeries->total_price }}">
                                Payment
                            </button>
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
                    <h5 class="modal-title" id="purchaseModalLabel">Purchase Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="purchase-form">
                        @csrf
                        <div class="mb-4">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jewel_name">Jewel Name</label>
                                    <input type="text" class="form-control" id="jewel_name" name="jewel_name" readonly>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="jewel_id" id="jewel_id">
                        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="amount" id="amount" required>

                        <div class="form-row mb-4">
                            <div class="form-group col-md-6">
                                <label for="total_price">Total Price</label>
                                <input type="text" class="form-control" id="total_price" name="total_price" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="customer_name">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="mobile_number">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" required>
                        </div>

                        <div class="form-group">
                            <label for="zip_code">Zip Code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" required></textarea>
                        </div>

                        <button type="button" class="btn btn-primary" id="pay-btn">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('home.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        $(document).ready(function () {
            // Event listener for the purchase button
            $('.purchase-btn').on('click', function () {
                const jewelId = $(this).data('jewel-id');
                const jewelName = $(this).data('jewel-name');
                const jewelPrice = parseFloat($(this).data('jewel-price'));

                // Set values in the modal
                $('#jewel_id').val(jewelId);
                $('#jewel_name').val(jewelName);
                $('#amount').val(jewelPrice * 100); // Convert to paise
                $('#total_price').val(jewelPrice.toFixed(2)); // Format total price
                $('#purchaseModal').modal('show'); // Show modal
            });

            // Event listener for the Pay Now button
            $('#pay-btn').on('click', function (e) {
                e.preventDefault(); // Prevent default form submission

                // Create Razorpay order options
                var amount = $('#amount').val(); // Amount in paise
                var options = {
                    key: "{{ env('RAZORPAY_KEY') }}", // Your Razorpay Key ID
                    amount: amount,
                    currency: "INR",
                    name: "Your Company Name", // Replace with your company name
                    description: "Purchase of Jewel",
                    image: "/images/logo-icon.png", // Company logo
                    handler: function (response) {
                        // On successful payment, send data to your backend
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('purchase.store') }}', // Update this to the correct route
                            data: {
                                _token: '{{ csrf_token() }}',
                                jewel_id: $('#jewel_id').val(),
                                user_id: $('#user_id').val(),
                                customer_name: $('#customer_name').val(),
                                email: $('#email').val(),
                                mobile_number: $('#mobile_number').val(),
                                zip_code: $('#zip_code').val(),
                                address: $('#address').val(),
                                razorpay_payment_id: response.razorpay_payment_id,
                                total_price: $('#total_price').val()
                            },
                            success: function (response) {
                                alert(response.message); // Success message
                                $('#purchaseModal').modal('hide'); // Hide modal
                                $('#purchase-form')[0].reset(); // Reset form
                                location.reload(); // Reload page to show updated data
                            },
                            error: function (xhr) {
                                alert(xhr.responseJSON.message || 'An error occurred.'); // Error handling
                            }
                        });
                    },
                    prefill: {
                        name: $('#customer_name').val(),
                        email: $('#email').val(),
                        contact: $('#mobile_number').val()
                    },
                    theme: {
                        color: "#28a745" // Theme color
                    }
                };

                // Show the Razorpay payment interface
                var rzp = new Razorpay(options);
                rzp.open(); // Open Razorpay modal
            });

        });
    </script>

</body>

</html>