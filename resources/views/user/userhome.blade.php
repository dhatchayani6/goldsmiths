<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: sans-serif;
            background-color: #f4f4f4;
        }

        .card {
            transition: transform 0.2s;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            max-width: 300px; /* Adjust max width */
            min-height: 450px;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.25rem;
            color: #333;
        }

        .card-text {
            flex-grow: 1;
        }

        .footer {
            bottom: 0;
            width: 100%;
        }

        h1,
        h2 {
            color: #343a40;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            color: black;
        }

        .container {
            max-width: 1410px;
        }

        .row {
            margin: 0; /* Reset row margin */
        }

        .col-md-3 {
            padding-bottom: 30px;
        }

        .nav-link:hover {
            color: #fff;
        }

        .navbar-light .navbar-brand {
            color: #fff !important;
        }

        .nav-link {
            color: #fff !important;
        }
    </style>
</head>

<body>
    @include('user.navbar')

    <div class="container mt-4">
        <h1>Welcome to User Dashboard</h1>
        <h2 class="mt-4">Available Jewels</h2>
        <div class="row" id="jewel-container">
            <!-- Jewels will be dynamically inserted here -->
        </div>
    </div>

    <!-- Pagination Links -->
    <div id="pagination-links" class="d-flex justify-content-center mt-3">
        <!-- Pagination links will be inserted here -->
    </div>

    @include('home.footer')

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            // Load jewels with pagination when the page is ready
            loadJewels();

            function loadJewels(page = 1) {
                $.ajax({
                    url: '{{ route('fetchjewel') }}?page=' + page,
                    type: 'GET',
                    success: function (response) {
                        $('#jewel-container').empty(); // Clear previous content
                        if (response.success && Array.isArray(response.data)) {
                            response.data.forEach(function (jewel) {
                                $('#jewel-container').append(`
                                    <div class="col-md-3"> <!-- Change col-md-4 to col-md-3 -->
                                        <div class="card mb-4">
                                            <img src="${jewel.jewel_image}" class="card-img-top" alt="${jewel.name}">
                                            <div class="card-body">
                                                <h5 class="card-title">${jewel.name}</h5>
                                                <p class="card-text">${jewel.description}</p>
                                                <p class="card-text"><strong>Price: $${jewel.price}</strong></p>
                                                <a href="/jewel/${jewel.id}" class="btn btn-primary">VIEW</a>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            });

                            // Handle pagination links
                            $('#pagination-links').html(response.links);
                            bindPagination();
                        } else {
                            console.error('Error: response.data is not an array or response.success is false');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error: ', status, error);
                    }
                });
            }

            function bindPagination() {
                $('.pagination a').click(function (e) {
                    e.preventDefault();
                    const page = $(this).attr('href').split('page=')[1];
                    loadJewels(page);
                });
            }
        });
    </script>
</body>

</html>
