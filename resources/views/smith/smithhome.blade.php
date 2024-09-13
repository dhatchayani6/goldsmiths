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
        .navbar-collapse {
            flex-grow: 0 !important;
        }

        .navbar-expand-lg {
            display: flex;
            justify-content: space-between;
            background: #eeee72;
            padding: 10px;
        }

        /* Sidebar styling */
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
            background: #eee;
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

        /* Content shift */
        #content-wrapper {
            margin-left: 250px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">Goldsmith Admin Menu</div>
        <ul class="list-unstyled">
            <li><a href="#">Dashboard</a></li>
            <li><a href="{{route('jewellery_page')}}">Add Jewelry</a></li>
            <li><a href="#">Manage Jewelry</a></li>
            <li><a href="#">Customer Orders</a></li>
            <li><a href="{{ route('logout') }}">Logout</a></li>
        </ul>
    </div>

    <!-- Page Content -->
    <div id="content-wrapper">
        <!-- Navbar -->
        <nav class="navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">Goldsmith Admin Panel</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Manage Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Orders</a>
                    </li>
                    <!-- Navbar Logout -->
                    <li class="nav-item">
                        <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <a class="nav-link" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Content Section -->
        <div class="container mt-4">
            <h1>Welcome to the Goldsmith Admin Dashboard</h1>
            <p>Manage jewelry, inventory, and orders from the sidebar.</p>
        </div>
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