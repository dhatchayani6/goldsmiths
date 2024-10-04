<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#">Gold Smith</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/homepage')}}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('profile.show')}}">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('show_customization_queries')}}">Customization Status</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('userqueries/{id}')}}">Query Status</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('chat')}}">Messages</a>
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

<style>
    .navbar {
        background: #ffcc00; /* Darker navbar color */
    }

    .navbar-brand {
        font-size: 1.5rem;
        color: #000000;
    }

    .navbar-nav .nav-link {
        color: #000000;
        font-size: 1.1rem;
    }

    .navbar-nav .nav-link:hover {
        color: #000000; /* Gold color on hover */
        cursor: pointer;
    }
</style>
