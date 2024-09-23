<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Purchase Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Jewels Available</h2>
        <table class="table" id="jewel-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic content will be appended here -->
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

                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="razorpay">Razorpay</option>
                                <option value="cash_on_delivery">Cash on Delivery</option>
                            </select>
                        </div>

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

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Fetch jewels on page load
            fetchJewels();

            function fetchJewels() {
                $.ajax({
                    url: '/purchasepageshow', // Ensure this route is correct
                    type: 'GET',
                    success: function (data) {
                        console.log(data); // Log data for debugging
                        const tbody = $('#jewel-table tbody');
                        tbody.empty(); // Clear the table body

                        // Append new rows to the table
                        $.each(data, function (index, jewel) {
                            const row = `<tr>
                                <td>${jewel.id}</td>
                                <td>${jewel.name}</td>
                                <td>$${jewel.price}</td>
                                <td>
                                    <button class="btn btn-success payment-btn" data-id="${jewel.id}">Payment</button>
                                </td>
                            </tr>`;
                            tbody.append(row);
                        });
                    },
                    error: function () {
                        alert('Error fetching jewels');
                    }
                });
            }

            $(document).on('click', '.payment-btn', function () {
                var jewelId = $(this).data('id');

                // Fetch jewel details via AJAX based on the jewel ID
                $.ajax({
                    url: '/purchasepageshow/' + jewelId, // Ensure this route is correct
                    type: 'GET',
                    success: function (data) {
                        console.log(data); // Log the data received
                        if (!data.error) {
                            $('#jewel_id').val(data.id);
                            $('#jewel_name').val(data.name);
                            $('#jewel_price').val(data.price);
                            $('#total_price').val(data.price); // Set initial total price

                            // Show the purchase modal
                            $('#purchaseModal').modal('show');
                        } else {
                            alert(data.error);
                        }
                    },
                    error: function () {
                        alert('Error fetching jewel details');
                    }
                });
            });

            // Update total price based on quantity
            $('#quantity').on('input', function () {
                var quantity = $(this).val();
                var price = $('#jewel_price').val();
                var totalPrice = quantity * price;
                $('#total_price').val(totalPrice.toFixed(2)); // Update total price
            });

            // Show/hide payment fields based on payment method
            $('#payment_method').change(function () {
                var selectedMethod = $(this).val();
                if (selectedMethod === 'card') {
                    $('#card-fields').removeClass('hidden').fadeIn();
                } else {
                    $('#card-fields').addClass('hidden');
                }
            });

            // Handle form submission via AJAX
            $('#purchase-form').on('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('purchase.store') }}", // Ensure this route is correct
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        alert('Purchase successful!'); // Handle success
                        $('#purchaseModal').modal('hide'); // Hide modal
                        $('#purchase-form')[0].reset(); // Reset form
                        fetchJewels(); // Refresh the jewels list
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        $.each(errors, function (key, value) {
                            errorMessages += value[0] + '\n';
                        });
                        alert('Error: \n' + errorMessages); // Display error messages
                    }
                });
            });
        });
    </script>
</body>

</html>
