<nav class="navbar navbar-expand-lg navbar-light px-3">
    <a class="navbar-brand" href="#">GOLDSMITH</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/homepage')}}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('managejewels')}}">Manage Jewels</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('chat')}}">Messages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('profile.show')}}">Profile</a>
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
        background: #ffcc00; /* Gold color */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding-left: 20px; /* Adjust as needed */
        padding-right: 20px; /* Adjust as needed */
    }
    .navbar-nav {
        align-items: center;
    }

    .nav-link{
            color: black !important;
        }
        .nav-link:hover{
            color: black ;
        }

    .nav-item{
        font-size: 20px;
    }
</style>
