<nav class="navbar navbar-expand-lg bg-light shadow-sm">
        <div class="container">
            <!-- Logo dan Nama -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://img.freepik.com/free-photo/shopping-cart-3d-render-icon_460848-6902.jpg" alt="Logo" width="40" height="40" class="d-inline-block align-text-top me-2">
                <span class="fw-bold">PhoneCulture</span>
            </a>
            
            <!-- Tombol Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Search Bar di Tengah -->
                <form class="d-flex mx-auto" role="search">
                    <input class="form-control me-2" type="search" placeholder="Cari..." aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                </form>
                
                <!-- Icon Keranjang dan Profile -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">
                            <i class="bi bi-cart fs-5"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>