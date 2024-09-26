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
        }
        body {
            font-family: sans-serif;

            background-color: #f4f4f4;
        }

        .card {
            transition: transform 0.2s;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column; /* Ensure contents are stacked */
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .card-img-top {
            height: 210px;
            object-fit: cover;
        }

        .card-body {
            text-align: center;
            flex-grow: 1; /* Allow card body to grow */
        }

        .card-title {
            font-size: 1.5rem;
            color: #333;
        }

            

        #notification-icon {
            position: relative;
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -10px;
        }

        h1, h2 {
            color: #343a40;
        }
        .navbar-light .navbar-nav .nav-link{
            color: black;
        }
        .navbar-light .navbar-nav .nav-link:hover{
            color: black;
        }
        .navbar{
            position: fixed;
            top: 0;
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

    @include('home.footer')

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            // Automatically load jewels when the page is ready
            $.ajax({
                url: '{{ route('fetchjewel') }}',
                type: 'GET',
                success: function (response) {
                    $('#jewel-container').empty(); // Clear previous content
                    if (response.success && Array.isArray(response.data)) {
                        response.data.forEach(function (jewel) {
                            $('#jewel-container').append(`
                                <div class="col-md-4">
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
                    } else {
                        console.error('Error: response.data is not an array or response.success is false');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error: ', status, error);
                }
            });
        });
    </script>
</body>

</html>
