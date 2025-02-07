<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <div class="d-flex">
            <a class="btn btn-success me-3" href="{{ route('login') }}">Login</a>
            <a class="btn btn-success me-3" href="{{ route('register') }}">Register</a>
            
        </div>

        <div class="mx-auto text-center">
            <div class="navbar-brand mt-0">
                <a href="{{ route('home') }}" class="text-decoration-none text-dark">ElectroniCulture</a>
            </div>
            <form class="d-flex mt-3" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
        </div>

        <div class="d-flex">
            <a class="nav-link mx-2" href="#">
                <i class="bi bi-bell fs-5"></i>
            </a>
            <a class="nav-link mx-2" href="#">
                <i class="bi bi-cart fs-5"></i>
            </a>
        </div>
    </div>
</nav>