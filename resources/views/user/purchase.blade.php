<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF token meta tag -->
    <title>Purchase Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .hidden {
            display: none;
        }

        .alert {
            margin-top: 20px;
        }

        /* Keyframe animations for form fields */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        /* Keyframe animation for modal */
        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .slide-up {
            animation: slideUp 0.5s ease-out;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Purchase Form</h2>
        <button class="btn btn-primary">
    <a href="{{ route('customize.jewel', ['id' => $fetchjewel]) }}" style="color: white; text-decoration: none;">Customize</a>
</button>
        <form id="purchase-form" class="fade-in" method="POST" action="{{ route('purchase.store') }}">
            <!-- Display Jewel Name and Price -->
            <div class="mb-4">
                <h4 class="mb-2">Jewel Name: <strong>{{ $fetchjewel->name }}</strong></h4>
                <p class="mb-3">Price: <strong>${{ $fetchjewel->price }}</strong></p>
            </div>

            <!-- Hidden input to store the jewel ID -->
            <input type="hidden" name="jewel_id" value="{{ $fetchjewel->id }}">
            <input type="hidden" name="amount" value="{{ $fetchjewel->price }}">

            <!-- Customer Details -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="customer_name">Customer Name</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="mobile_number">Mobile Number</label>
                    <input type="text" class="form-control" id="mobile_number" name="mobile_number" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="zip_code">Zip Code</label>
                    <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" required></textarea>
            </div>

            <!-- Payment Method -->
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <option value="">Select Payment Method</option>
                    <option value="card">Credit/Debit Card</option>
                    <option value="razorpay">Razorpay</option>
                    <option value="cash_on_delivery">Cash on Delivery</option>
                </select>
            </div>

            <!-- Card Payment Fields -->
            <div id="card-fields" class="hidden">
                <div class="form-group">
                    <label for="card_name">Cardholder Name</label>
                    <input type="text" class="form-control" id="card_name" name="card_name">
                </div>
                <div class="form-group">
                    <label for="card_number">Card Number</label>
                    <input type="text" class="form-control" id="card_number" name="card_number">
                </div>
                <div class="form-group">
                    <label for="expiry_date">Expiry Date</label>
                    <input type="text" class="form-control" id="expiry_date" name="expiry_date">
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" class="form-control" id="cvv" name="cvv">
                </div>
            </div>

            <!-- PayPal Payment Fields -->
            <div id="paypal-fields" class="hidden">
                <div class="form-group">
                    <label for="paypal_order_id">PayPal Order ID</label>
                    <input type="text" class="form-control" id="paypal_order_id" name="paypal_order_id">
                </div>
            </div>

            <!-- Razorpay Payment Fields -->
            <div id="razorpay-fields" class="hidden">
                <div class="form-group">
                    <label for="razorpay_payment_id">Razorpay Payment ID</label>
                    <input type="text" class="form-control" id="razorpay_payment_id" name="razorpay_payment_id">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- Modal for Success Message -->
        <div class="modal fade slide-up" id="successModal" tabindex="-1" role="dialog"
            aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Success</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="successMessage">
                        <!-- Success message will be injected here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Section -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            const paymentMethodSelect = $("#payment_method");
            const cardFields = $("#card-fields");
            const razorpayFields = $("#razorpay-fields");

            // Get the CSRF token from the meta tag
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            function updatePaymentFields() {
                const paymentMethod = paymentMethodSelect.val();

                // Hide all payment fields initially
                cardFields.addClass("hidden");
                razorpayFields.addClass("hidden");

                // Show fields based on selected payment method
                if (paymentMethod === "card") {
                    cardFields.removeClass("hidden");
                } else if (paymentMethod === "razorpay") {
                    razorpayFields.removeClass("hidden");
                }
                // No fields needed for "Cash on Delivery"
            }

            paymentMethodSelect.on("change", updatePaymentFields);
            updatePaymentFields(); // Initialize visibility on page load

            $("#purchase-form").on("submit", function (event) {
                event.preventDefault(); // Prevent the default form submission

                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('purchase.store') }}", // Replace with your route name
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Add CSRF token to the headers
                    },
                    success: function (response) {
                        $("#successMessage").html('<p>' + response.message + '</p>');
                        $("#successModal").modal('show'); // Show success modal
                        $("#purchase-form")[0].reset(); // Reset the form
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '<ul>';
                        $.each(errors, function (key, value) {
                            errorMessages += '<li>' + value[0] + '</li>';
                        });
                        errorMessages += '</ul>';
                        $("#successMessage").html('<p>' + errorMessages + '</p>');
                        $("#successModal").modal('show'); // Show error modal
                    }
                });
            });
        });
    </script>
</body>

</html>