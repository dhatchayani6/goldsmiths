<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .navbar {
            background: #eeeeee;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        .card-img-top {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .card-body {
            text-align: center;
        }

        .card-title {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">User Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Dashboard <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('show_customization_queries')}}">Customization Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="notification-icon"> <!-- Link to the status page -->
                        <i class="fas fa-bell"></i>
                        <span class="badge badge-danger" style="position: absolute; top: 0; right: 0;">3</span> <!-- Example badge -->
                    </a>
                </li>
                @if (Auth::check())
                <form class="form-inline" method="post" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger my-2 my-sm-0">LOGOUT ({{ Auth::user()->name }})</button>
                </form>
                @endif
            </ul>
        
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Welcome to Your Dashboard</h1>
        <p>Here you can manage your profile, view your orders, and access various settings.</p>
        <h2>Available Jewels</h2>
        <div class="row" id="jewel-container">
            <!-- Jewels will be dynamically inserted here -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            // Automatically load jewels when the page is ready
            $.ajax({
                url: '{{ route('fetchjewel') }}',  // Replace with your actual API endpoint
                type: 'GET',
                success: function (response) {
                    $('#jewel-container').empty(); // Clear previous content
                    if (response.success && Array.isArray(response.data)) {
                        response.data.forEach(function (jewel) {
                            $('#jewel-container').append(`
                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <img src="${jewel.jewel_image}" class="card-img-top" alt="${jewel.name}" style="height: 210px; object-fit: fill;">
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
