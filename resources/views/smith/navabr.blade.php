<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">GOLDSMITH</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"> <!-- Use ml-auto to align items to the right -->
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('chat')}}">Messages</a>
                </li>
                @if (Auth::check())
                    <li class="nav-item">
                        <form method="post" action="{{ route('logout') }}" class="nav-link">
                            @csrf
                            <button class="btn btn-outline-danger my-2 my-sm-0">LOGOUT ({{ Auth::user()->name }})</button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    <style>
        .navbar {
            background: #ffcc00;
            /* Gold color */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .navbar-nav {
            align-items: center;
        }
    </style>