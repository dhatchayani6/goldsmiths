<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Jewel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f1f3f5;
            font-family: 'Montserrat', sans-serif;
        }

        .jewel-container {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
            max-width: 600px;
        }

        .section-title {
            margin-top: 30px;
            font-size: 2rem;
            font-weight: bold;
            color: #5a5a5a;
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #dee2e6;
        }

        .jewel-details {
            background-color: #fafafa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .jewel-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
        }

        .jewel-price {
            font-weight: bold;
            color: #28a745;
        }

        .btn-success {
            background: linear-gradient(45deg, #28a745, #1e7e34);
            border: none;
            transition: background 0.3s;
        }

        .modal-header {
            background-color: #28a745;
            color: #fff;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #28a745;
        }

        #response-message {
            margin-top: 20px;
            font-weight: bold;
            border-radius: 0.5rem;
        }

        .footer {
            position: fixed;
            bottom: 0 !important;
        }

        .navbar-light .navbar-nav .nav-link {
            color: black;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            color: black;
        }
    </style>
</head>

<body>
    @include('user.navbar')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 jewel-container">
                <h2 class="section-title">Purchase Page</h2>
                <div class="jewel-details">
                    <h5 class="jewel-name">{{ $jewels->name }}</h5>
                    <p class="jewel-price">Price: ${{ $jewels->price }}</p>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#purchaseModal">Purchase</button>

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
                                            <label for="jewel_name">Jewel Name</label>
                                            <input type="text" class="form-control" id="jewel_name" name="jewel_name" value="{{ $jewels->name }}" readonly>
                                            <input type="hidden" name="jewel_id" value="{{ $jewels->id }}">
                                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                            <input type="hidden" name="amount" id="amount" value="{{ $jewels->price * 100 }}"> <!-- Amount in paise -->
                                            <input type="hidden" name="payment_method" value="razorpay">
                                        </div>

                                        <div class="mb-4">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control quantity" id="quantity" name="quantity" min="1" value="1">
                                        </div>

                                        <div class="mb-4">
                                            <label for="total_price">Total Price</label>
                                            <input type="text" class="form-control" id="total_price" name="total_price" value="{{ $jewels->price }}" readonly>
                                        </div>

                                        <div class="mb-4">
                                            <label for="customer_name">Customer Name</label>
                                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="mobile_number">Mobile Number</label>
                                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="zip_code">Zip Code</label>
                                            <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" id="address" name="address" required></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success w-100">Proceed to Payment</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Response Message Area -->
                    <div class="alert alert-dismissible fade show d-none" role="alert" id="response-message">
                        <span id="message-content"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('home.footer')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $(document).ready(function () {
            // Calculate total price based on quantity
            $('#quantity').on('input', function () {
                var quantity = $(this).val();
                var price = {{ $jewels->price }};
                $('#total_price').val(price * quantity);
            });

            // Submit the purchase form
            $('#purchase-form').on('submit', function (e) {
                e.preventDefault();

                // Create Razorpay order
                var amount = $('#amount').val(); // Amount in paise
                var options = {
                    key: "{{ env('RAZORPAY_KEY') }}", // Your Razorpay Key ID
                    amount: amount,
                    currency: "INR",
                    name: "Your Company Name",
                    description: "Purchase of Jewel",
                    image: "/images/logo-icon.png",
                    handler: function (response) {
                        // On successful payment, handle the response and send the data to your backend
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('purchase.store') }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                                jewel_id: $('input[name="jewel_id"]').val(),
                                user_id: $('input[name="user_id"]').val(),
                                quantity: $('#quantity').val(),
                                customer_name: $('#customer_name').val(),
                                email: $('#email').val(),
                                mobile_number: $('#mobile_number').val(),
                                zip_code: $('#zip_code').val(),
                                address: $('#address').val(),
                                razorpay_payment_id: response.razorpay_payment_id,
                                total_price: $('#total_price').val()
                            },
                            success: function (response) {
                                $('#message-content').text(response.message);
                                $('#response-message').removeClass('d-none').addClass('alert-success');
                                $('#purchaseModal').modal('hide');

                                // Reload the page after a short delay to show the success message
                                setTimeout(function() {
                                    location.reload();
                                }, 2000); // Adjust the time as needed
                            },
                            error: function (xhr) {
                                $('#message-content').text(xhr.responseJSON.message || 'An error occurred.');
                                $('#response-message').removeClass('d-none').addClass('alert-danger');
                            }
                        });
                    },
                    prefill: {
                        name: $('#customer_name').val(),
                        email: $('#email').val(),
                        contact: $('#mobile_number').val()
                    },
                    theme: {
                        color: "#28a745"
                    }
                };

                // Show the Razorpay payment interface
                var rzp = new Razorpay(options);
                rzp.open();
            });
        });
    </script>
</body>

</html>
