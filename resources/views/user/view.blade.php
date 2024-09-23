<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .jewel-container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .jewel-image {
            border-radius: 8px;
        }
        .section-title {
            margin-top: 30px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        .query-card {
            background: #f1f1f1;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
        }
        .query-item {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            background-color: #fff;
        }
        .btn-purchase {
            width: 100%;
        }
        .query-name {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 jewel-container">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{$jewel->jewel_image}}" alt="{{ $jewel->name }}" class="img-fluid jewel-image img-thumbnail" style="height: 400px; width: 100%; object-fit: cover;">
                    </div>
                    <div class="col-md-6 jewel-details">
                        <h1 class="jewel-name">{{ $jewel->name }}</h1>
                        <p class="jewel-description">{{ $jewel->description }}</p>
                        <p class="jewel-price">Price: ${{ $jewel->price }}</p>
                        <a href="{{ url('purchasepageshow', parameters: ['id' => $jewel->id]) }}" class="btn btn-success btn-purchase">Purchase</a>
                        <button class="btn btn-primary">
                            <a href="{{ route('customize.jewel', ['id' => $jewel]) }}" style="color: white; text-decoration: none;">Customize</a>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Query Section -->
            <div class="col-lg-8 query-section">
                <h2 class="section-title">Have a Query About This Jewel?</h2>
                <div class="query-card">
                    <form id="queryForm" action="{{ route('jewel.query', $jewel->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="query_name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="query_name" name="query_name" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="query_email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="query_email" name="query_email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="query_message" class="form-label">Your Query</label>
                            <textarea class="form-control" id="query_message" name="query_message" rows="4" placeholder="Enter your query" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">Submit Query</button>
                    </form>
                </div>
            </div>

            
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery for AJAX -->
    <script>
        $(document).ready(function () {
            // Handle form submission via AJAX
            $('#queryForm').on('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: $(this).attr('action'), // Form action URL
                    type: 'POST', // Form method
                    data: $(this).serialize(), // Form data
                    success: function (response) {
                        // Handle success response
                        alert('Your query has been submitted successfully!');
                        $('#queryForm')[0].reset(); // Reset the form fields
                    },
                    error: function (xhr) {
                        // Handle error response
                        alert('An error occurred. Please try again.');
                    }
                });
            });

            // Fetch and display queries
            $.ajax({
                url: '{{ route('jewel.show', $jewel->id) }}', // URL to fetch queries
                type: 'GET',
                success: function (response) {
                    let queriesHtml = '';
                    if (response.length > 0) {
                        response.forEach(function (query) {
                            queriesHtml += `
                                <div class="query-item">
                                    <h5 class="query-name">${query.query_name}</h5>
                                    <p class="query-email">Email: ${query.query_email}</p>
                                    <p class="query-message">${query.query_message}</p>
                                    <hr>
                                </div>
                            `;
                        });
                    } else {
                        queriesHtml = '<p>No queries found.</p>';
                    }
                    $('#queriesList').html(queriesHtml);
                },
                error: function (xhr) {
                    $('#queriesList').html('<p>An error occurred while fetching queries.</p>');
                }
            });
        });
    </script>
</body>

</html>
