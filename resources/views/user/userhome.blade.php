<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        .navbar-collapse {
            flex-grow: 0 !important;
        }

        .navbar-expand-lg {
            display: flex;
            justify-content: space-between;
            background: #eeeeee;
            padding: 10px;
        }

        #sidebar-wrapper {
            height: 100vh;
            width: 250px;
            background-color: #f8f9fa;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 1rem;
            background: #e9ecef;
            font-size: 1.25rem;
            text-align: center;
        }

        #sidebar-wrapper ul {
            list-style: none;
            padding: 0;
        }

        #sidebar-wrapper ul li {
            padding: 10px;
            font-size: 16px;
        }

        #sidebar-wrapper ul li a {
            display: block;
            text-decoration: none;
            color: #333;
        }

        #sidebar-wrapper ul li a:hover {
            background-color: #ddd;
            padding-left: 10px;
        }

        #content-wrapper {
            margin-left: 250px;
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
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">User Menu</div>
        <ul class="list-unstyled">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Orders</a></li>
            <li><a href="#">Messages</a></li>
            <li><a href="#">Settings</a></li>
            <li>    <a href="{{ url('/jewel/${jewel.id}') }}" class="btn btn-info">Status</a>
            </li>
            <li><a href="#">Help</a></li>
        </ul>
    </div>
    <div id="content-wrapper">
        <nav class="navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">User Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Orders</a>
                    </li>
                    @if (Auth::check())
                        <li>
                            <form method="post" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-primary">LOGOUT ({{ Auth::user()->name }})</button>
                            </form>
                        </li>
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
                                        <img src="${jewel.jewel_image}" class="card-img-top" alt="${jewel.name}" style="height: 210px;
    object-fit: fill;">
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