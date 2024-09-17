<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h2 class="text-center">Purchase</h2>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form id="purchaseForm" action="{{ route('purchase.store') }}" method="POST">
                    @csrf

                    <!-- Display Jewel Name and Price -->
                    <div class="mb-3">
                        <h4>Jewel Name: <strong>{{ $fetchjewel->name }}</strong></h4>
                        <p>Price: <strong>${{ $fetchjewel->price }}</strong></p>
                    </div>

                    <!-- Hidden input to store the jewel ID -->
                    <input type="hidden" name="jewel_id" value="{{ $fetchjewel->id }}">

                    <!-- Customer Details -->
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="mobile_number" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" required>
                    </div>

                    <div class="mb-3">
                        <label for="zip_code" class="form-label">Zip Code</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Shipping Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select id="payment_method" name="payment_method" class="form-select" required>
                            <option value="cod">Cash on Delivery</option>
                            <option value="paypal">Online Payment</option>
                        </select>
                    </div>

                    <!-- PayPal Button Container -->
                    <div id="paypal-button-container" class="d-none mt-3"></div>

                    <!-- Credit Card Information (conditionally displayed if Credit Card selected) -->
                    <div id="credit_card_info" class="d-none">
                        <div class="mb-3">
                            <label for="card_number" class="form-label">Card Number</label>
                            <input type="text" class="form-control" id="card_number" name="card_number">
                        </div>
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY">
                        </div>
                        <div class="mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cvv" name="cvv">
                        </div>
                    </div>

                    <!-- PayPal Email (conditionally displayed if PayPal selected) -->
                    

                    <button type="submit" class="btn btn-primary w-100">Confirm Purchase</button>
                </form>
            </div>
        </div>
    </div>

 
    <!-- PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=Aew2g2XOHD-s3IdBaQuVPFocouusQwNSMeNUL9n6TEAGowSRwVG5Q3Ax3ojl0irQqZPd4gVThfLAUSsk&components=buttons"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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
                                        id: "{{ $fetchjewel->id }}", // Use actual product ID
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
                                window.location.href = '/thank-you';
                            }
                        } catch (error) {
                            console.error('Error capturing PayPal payment:', error);
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
