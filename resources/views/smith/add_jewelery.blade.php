<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goldsmith Admin Dashboard - Add New Jewelry</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            background-color: #f7f7f7;
        }

        .navbar {
            background: #ffcc00;
            /* Gold color */
        }

        #content-wrapper {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: white;
            flex: 1;
        }

        h1 {
            color: #333;
        }

        .footer {
            text-align: center;
            padding: 10px;
            color: #666;
        }

        #successMessage {
            display: none;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    @include('smith.navabr')

    <!-- Page Content -->
    <div id="content-wrapper">
        <div class="container mt-4">
            <h1 class="mb-4">Add New Jewelry</h1>

            <!-- Success Message -->
            <div id="successMessage" class="alert alert-success" role="alert"></div>

            <!-- Jewelry Form -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <form id="addJewelryForm" enctype="multipart/form-data">
                            @csrf
                            <div id="alertMessage" class="alert d-none"></div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jewelryName">Jewelry Name</label>
                                    <input type="text" class="form-control" id="jewelryName" name="jewelryName"
                                        placeholder="Enter jewelry name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jewelryType">Jewelry Type</label>
                                    <select class="form-control" id="jewelryType" name="jewelryType" required>
                                        <option value="">Select type</option>
                                        <option value="Necklace">Necklace</option>
                                        <option value="Ring">Ring</option>
                                        <option value="Bracelet">Bracelet</option>
                                        <option value="Earrings">Earrings</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jewelryWeight">Weight (in grams)</label>
                                    <input type="number" class="form-control" id="jewelryWeight" name="jewelryWeight"
                                        placeholder="Enter weight" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jewelryPrice">Price</label>
                                    <input type="number" class="form-control" id="jewelryPrice" name="jewelryPrice"
                                        placeholder="Enter price" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="jewelryDescription">Description</label>
                                <textarea class="form-control" id="jewelryDescription" name="jewelryDescription"
                                    rows="3" placeholder="Enter jewelry description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="jewelryImage">Upload Image</label>
                                <input type="file" class="form-control-file" id="jewelryImage" name="jewelryImage"
                                    accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-primary">Add Jewelry</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 Goldsmith Admin Panel. All Rights Reserved.</p>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

        <script>
    $(document).ready(function () {
        $('#addJewelryForm').on('submit', function (e) {
            e.preventDefault(); // Prevent form from submitting the default way

            // Create a FormData object to hold the form data
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('jewel.store') }}",  // Laravel route to handle form submission
                method: "POST",
                data: formData,
                contentType: false,  // For file uploads, this must be false
                processData: false,  // For file uploads, this must be false
                success: function (response) {
                    if (response.status === 'success') {
                        // Show the success message
                        $('#successMessage').text('Jewelry added successfully!').show();  // Show success message
                        
                        // Reset the form after successful submission
                        $('#addJewelryForm')[0].reset();

                        // Reload the page after a brief delay
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000); // Adjust the delay as needed

                        // Optionally hide the success message after a few seconds
                        setTimeout(function () {
                            $('#successMessage').fadeOut();
                        }, 5000);
                    }
                },
                error: function (response) {
                    var errors = response.responseJSON.errors;
                    var errorHtml = '<ul>';
                    $.each(errors, function (key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                    errorHtml += '</ul>';

                    $('#alertMessage')
                        .removeClass('d-none alert-success')
                        .addClass('alert-danger')
                        .html(errorHtml)
                        .fadeIn();

                    // Optionally hide the alert after a few seconds
                    setTimeout(function () {
                        $('#alertMessage').fadeOut();
                    }, 5000);
                }
            });
        });
    });
</script>


</body>

</html>
