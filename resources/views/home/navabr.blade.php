<!-- Bootstrap Navbar with Custom Styling -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand" href="#">Gold Smith</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Sign in</a>
            </li>

            @if (Auth::check())
            <form class="form-inline" method="post" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-danger my-2 my-sm-0 d-none">LOGOUT ({{ Auth::user()->name }})</button>
            </form>
            @endif
        </ul>
    </div>
</nav>
