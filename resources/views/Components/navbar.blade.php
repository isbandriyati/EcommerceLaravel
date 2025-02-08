<nav class="navbar navbar-expand-lg navbar-primary bg-primary fixed-top">
    <div class="container">
        <!-- Bagian Kiri: Login/Register atau Profil -->
        <div class="d-flex">
            @guest
                <a class="btn btn-yellow me-3" href="{{ route('login') }}">Login</a>
                <a class="btn btn-yellow me-3" href="{{ route('register') }}">Register</a>
            @else
                <!-- Dropdown Profile -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4 me-1"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-pencil-square me-2"></i>Edit Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>

        <!-- Bagian Tengah: Nama Brand & Pencarian -->
        <div class="mx-auto text-center">
            <div class="navbar-brand mt-0">
                <a href="{{ route('home') }}" class="text-decoration-none text-warning">ElectroniCulture</a>
            </div>
            <form class="d-flex mt-3" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
        </div>

        <!-- Bagian Kanan: Notifikasi & Keranjang -->
        <div class="d-flex">
            <a class="nav-link mx-2" href="#">
                <i class="bi bi-bell fs-4 text-warning"></i>
            </a>
            <a class="nav-link mx-2" href="#">
                <i class="bi bi-cart fs-4 text-warning"></i>
            </a>
        </div>
    </div>
</nav>
