<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Purchase Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
        }

        h2 {
            margin-bottom: 30px;
            color: #343a40;
        }

        .form-group label {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .alert {
            margin-top: 20px;
        }

        .hidden {
            display: none;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add your custom styles here */
        .hidden {
            display: none;
        }

        .fade-in {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Jewels Available</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jewels as $jewel)
                    <tr>
                        <td>{{ $jewel->id }}</td>
                        <td>{{ $jewel->name }}</td>
                        <td>${{ $jewel->price }}</td>
                        <td>
                            <button class="btn btn-success payment-btn" data-id="{{ $jewel->id }}" data-name="{{ $jewel->name }}" data-price="{{ $jewel->price }}">Payment</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Purchase Form Modal -->
    <div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="purchaseModalLabel">Purchase Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="purchase-form" method="POST" action="{{ route('purchase.store') }}">
                        @csrf
                        <div class="mb-4">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jewel_name">Jewel Name</label>
                                    <input type="text" class="form-control" id="jewel_name" name="jewel_name" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jewel_price">Price</label>
                                    <input type="text" class="form-control" id="jewel_price" name="jewel_price" readonly>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="jewel_id" id="jewel_id">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="amount" id="amount">

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

                        <div class="form-row mb-4">
                            <div class="form-group col-md-6">
                                <label for="total_price">Total Price</label>
                                <input type="text" class="form-control" id="total_price" name="total_price" readonly>
                            </div>
                        </div>

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
                                <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY">
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV</label>
                                <input type="text" class="form-control" id="cvv" name="cvv">
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
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Success Message -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="successMessage"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Handle the payment button click
            $('.payment-btn').click(function () {
                var jewelId = $(this).data('id');
                var jewelName = $(this).data('name');
                var jewelPrice = $(this).data('price');

                // Set the values in the purchase form
                $('#jewel_id').val(jewelId);
                $('#jewel_name').val(jewelName);
                $('#jewel_price').val(jewelPrice);
                $('#amount').val(jewelPrice);
                $('#total_price').val('$' + jewelPrice); // Format the price

                // Show the purchase modal
                $('#purchaseModal').modal('show');
            });

            // Show/hide payment fields based on payment method
            $('#payment_method').change(function () {
                var selectedMethod = $(this).val();
                if (selectedMethod === 'card') {
                    $('#card-fields').removeClass('hidden').fadeIn();
                    $('#razorpay-fields').addClass('hidden');
                } else if (selectedMethod === 'razorpay') {
                    $('#razorpay-fields').removeClass('hidden').fadeIn();
                    $('#card-fields').addClass('hidden');
                } else {
                    $('#card-fields, #razorpay-fields').addClass('hidden');
                }
            });
        });
    </script>
</body>

</html>


    <!-- JavaScript Section -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            const paymentMethodSelect = $("#payment_method");
            const cardFields = $("#card-fields");
            const razorpayFields = $("#razorpay-fields");
            const jewelPrice = parseFloat($("#jewel_price").val().replace(/[^0-9.-]+/g,"")); // Get jewel price
            const quantityInput = $("#quantity");
            const totalPriceInput = $("#total_price");

            function updateTotalPrice() {
                const quantity = parseInt(quantityInput.val());
                if (!isNaN(quantity) && quantity > 0) {
                    const totalPrice = jewelPrice * quantity; // Calculate total price
                    totalPriceInput.val(`Rs.${totalPrice.toFixed(0)}`); // Update total price input
                } else {
                    totalPriceInput.val(`Rs.${jewelPrice.toFixed(0)}`); // Reset if quantity is invalid
                }
            }

            quantityInput.on("input", updateTotalPrice); // Recalculate total price on quantity change

            function updatePaymentFields() {
                const paymentMethod = paymentMethodSelect.val();
                cardFields.addClass("hidden");
                razorpayFields.addClass("hidden");

                if (paymentMethod === "card") {
                    cardFields.removeClass("hidden");
                } else if (paymentMethod === "razorpay") {
                    razorpayFields.removeClass("hidden");
                }
            }

            paymentMethodSelect.on("change", updatePaymentFields);
            updatePaymentFields(); // Initialize visibility on page load
            updateTotalPrice(); // Initialize total price on page load

            $("#purchase-form").on("submit", function (event) {
                event.preventDefault(); // Prevent the default form submission

                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('purchase.store') }}", // Replace with your route name
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $("#successMessage").html('<p>' + response.message + '</p>');
                        $("#successModal").modal('show');
                        $("#purchase-form")[0].reset(); // Reset the form
                        updateTotalPrice(); // Reset total price after form reset
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '<ul>';
                        $.each(errors, function (key, value) {
                            errorMessages += '<li>' + value[0] + '</li>';
                        });
                        errorMessages += '</ul>';
                        $("#successMessage").html('<p>' + errorMessages + '</p>');
                        $("#successModal").modal('show');
                    }
                });
            });
        });
    </script>
</body>

</html>
