<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
        }
        .form-section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-section h4 {
            margin-bottom: 20px;
        }
        .form-section .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s, transform 0.3s;
        }
        .form-section .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .alert {
            margin-bottom: 20px;
        }
        /* Animation for form field focus */
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        /* Fade-in effect for sections */
        .fade-in {
            opacity: 0;
            transition: opacity 0.5s ease-in;
        }
        .fade-in.show {
            opacity: 1;
        }
    </style>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="form-section">
                    <h2 class="text-center mb-4">Purchase</h2>
                    
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form id="purchaseForm" action="{{ route('purchase.store') }}" method="POST">
                        @csrf

                        <!-- Display Jewel Name and Price -->
                        <div class="mb-4">
                            <h4 class="mb-2">Jewel Name: <strong>{{ $fetchjewel->name }}</strong></h4>
                            <p class="mb-3">Price: <strong>${{ $fetchjewel->price }}</strong></p>
                        </div>

                        <!-- Hidden input to store the jewel ID -->
                        <input type="hidden" name="jewel_id" value="{{ $fetchjewel->id }}">
                        <input type="hidden" name="amount" value="{{ $fetchjewel->price }}">


                        <!-- Hidden input to store the PayPal Order ID -->
                        <input type="hidden" name="paypal_order_id" id="paypal_order_id">

                        <!-- Customer Details -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required minlength="2" placeholder="Enter your name">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="mobile_number" class="form-label">Mobile Number</label>
                                <input type="tel" class="form-control" id="mobile_number" name="mobile_number" required pattern="[0-9]{10}" placeholder="Enter your mobile number">
                                <small class="form-text text-muted">Please enter a 10-digit mobile number.</small>
                            </div>
                            <div class="col-md-6">
                                <label for="zip_code" class="form-label">Zip Code</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" required pattern="[0-9]{5}" placeholder="Enter your zip code">
                                <small class="form-text text-muted">Please enter a 5-digit zip code.</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Shipping Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required placeholder="Enter your shipping address"></textarea>
                        </div>

                        <!-- Payment Method Selection -->
                        <div class="mb-4">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select id="payment_method" name="payment_method" class="form-select" required>
                                <option value="cod">Cash on Delivery</option>
                                <option value="paypal">Online Payment (PayPal)</option>
                                <option value="creditcard">Online Payment (Credit Card)</option>
                            </select>
                        </div>

                        <!-- PayPal Button Container -->
                        <div id="paypal-button-container" class="d-none fade-in mb-4"></div>

                        <!-- Credit Card Information -->
                        <div id="credit_card_info" class="d-none fade-in">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="card_name" class="form-label">Cardholder Name</label>
                                    <input type="text" class="form-control" id="card_name" name="card_name" required placeholder="Enter cardholder name">
                                </div>
                                <div class="col-md-6">
                                    <label for="card_number" class="form-label">Card Number</label>
                                    <input type="text" class="form-control" id="card_number" name="card_number" required pattern="\d{13,16}" placeholder="Enter card number">
                                    <small class="form-text text-muted">Card number should be between 13 and 16 digits.</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="form-label">Expiry Date</label>
                                    <input type="text" class="form-control" id="expiry_date" name="expiry_date" required pattern="\d{2}/\d{2}" placeholder="MM/YY">
                                    <small class="form-text text-muted">Enter in MM/YY format.</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" name="cvv" required pattern="\d{3}" placeholder="Enter CVV">
                                    <small class="form-text text-muted">CVV should be 3 digits.</small>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Confirm Purchase</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=Aew2g2XOHD-s3IdBaQuVPFocouusQwNSMeNUL9n6TEAGowSRwVG5Q3Ax3ojl0irQqZPd4gVThfLAUSsk&components=buttons"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const paymentMethodSelect = document.getElementById('payment_method');
            const paypalButtonContainer = document.getElementById('paypal-button-container');
            const creditCardInfo = document.getElementById('credit_card_info');
            const paypalOrderIdField = document.getElementById('paypal_order_id');

            // Add fade-in class to sections initially
            paypalButtonContainer.classList.add('fade-in');
            creditCardInfo.classList.add('fade-in');

            paymentMethodSelect.addEventListener('change', function () {
                if (paymentMethodSelect.value === 'paypal') {
                    paypalButtonContainer.classList.remove('d-none');
                    creditCardInfo.classList.add('d-none');
                    paypalButtonContainer.classList.add('show');
                } else if (paymentMethodSelect.value === 'creditcard') {
                    paypalButtonContainer.classList.add('d-none');
                    creditCardInfo.classList.remove('d-none');
                    creditCardInfo.classList.add('show');
                } else {
                    paypalButtonContainer.classList.add('d-none');
                    creditCardInfo.classList.add('d-none');
                }
            });

            if (window.paypal && window.paypal.Buttons) {
                window.paypal.Buttons({
                    style: {
                        shape: "rect",
                        layout: "vertical",
                        color: "gold",
                        label: "paypal",
                    },
                    createOrder: async function () {
                        try {
                            const response = await fetch("/api/orders", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify({
                                    item: {
                                        id: "{{ $fetchjewel->id }}", // Replace with actual product ID
                                        quantity: 1
                                    }
                                }),
                            });

                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }

                            const orderData = await response.json();
                            return orderData.id;
                        } catch (error) {
                            console.error('Error creating PayPal order:', error);
                            alert('There was an error creating the PayPal order. Please try again.');
                        }
                    },
                    onApprove: async function (data) {
                        try {
                            const response = await fetch(`/api/orders/${data.orderID}/capture`, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                            });

                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }

                            const orderData = await response.json();
                            console.log("Capture result", orderData);
                            if (orderData && orderData.status === 'COMPLETED') {
                                alert(`Transaction completed successfully: ${orderData.id}`);
                                // Set the PayPal Order ID in the hidden field
                                paypalOrderIdField.value = orderData.id;
                                // Submit the form
                                document.getElementById('purchaseForm').submit();
                            } else {
                                alert('Transaction not completed successfully.');
                            }
                        } catch (error) {
                            console.error('Error capturing PayPal payment:', error);
                            alert('There was an error capturing the PayPal payment. Please try again.');
                        }
                    }
                }).render("#paypal-button-container");
            } else {
                console.error("PayPal Buttons are not available.");
            }
        });
    </script>
</body>
</html>
