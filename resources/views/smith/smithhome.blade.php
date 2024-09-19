<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goldsmith Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            background-color: #f7f7f7;
        }

        .navbar {
            background: #ffcc00; /* Gold color */
        }

        /* Content section styling */
        #content-wrapper {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: white;
            flex: 1; /* Allow content to grow and fill space */
        }

        h1 {
            color: #333;
        }

        .card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 8px;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 150px; /* Set a fixed height for images */
            object-fit: cover; /* Cover to maintain aspect ratio */
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-title {
            font-weight: bold;
            color: #444;
        }

        .card-text {
            color: #777;
        }

        .footer {
            text-align: center;
            padding: 10px;
            color: #666;
        }
    </style> ippo theriyutha
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Goldsmith Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
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

    <!-- Page Content -->
    <div id="content-wrapper">
        <div class="container mt-4">
            <h1>Welcome to the Goldsmith Admin Dashboard</h1>
            <p>Manage jewelry, inventory, and orders from the cards below.</p>

            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-center" onclick="window.location='{{ route('jewellery_page') }}'">
                        <img src="images/addjewley.jpg" class="card-img-top" alt="Add Jewelry">
                        <div class="card-body">
                            <h5 class="card-title">Add Jewelry</h5>
                            <p class="card-text">Add new jewelry items to your inventory.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center" onclick="window.location='#'">
                        <img src="images/addjewley.jpg" class="card-img-top" alt="Customer Orders">
                        <div class="card-body">
                            <h5 class="card-title">Customer Orders</h5>
                            <p class="card-text">View and manage customer orders.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center" onclick="window.location='{{ route('jewel.queries') }}'">
                        <img src="images/addjewley.jpg" class="card-img-top" alt="User Queries">
                        <div class="card-body">
                            <h5 class="card-title">User Queries</h5>
                            <p class="card-text">View user queries regarding jewelry.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center" onclick="window.location='{{ route('getcustomqueries') }}'">
                        <img src="images/addjewley.jpg" class="card-img-top" alt="Custom Jewelry Query">
                        <div class="card-body">
                            <h5 class="card-title">Custom Jewelry Query</h5>
                            <p class="card-text">Handle queries for custom jewelry requests.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Goldsmith Admin Panel. All Rights Reserved.</p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>
