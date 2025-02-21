@props(['categories', 'carts'])

<nav class="navbar navbar-expand-lg shadow-sm fixed-top py-3 custom-navbar">
    <div class="container align-items-center">
        
        <!-- Logo -->
        <a class="navbar-brand fw-bold fs-3" href=" {{route (('home')) }}">GitalBox</a>

        <!-- Kategori -->
        <div class="cart-container">
            <a href="{{ route('products.index') }}" class="kategori-icon">Kategori</a>

            <!-- Floating Dropdown -->
            <div id="cart-dropdown" class="kategori-dropdown">
                <ul>
                @foreach ($categories as $category)
                    <li>
                        <a class="dropdown-item kategori-item" href="{{ route('index.category', $category->id) }}">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="me-2 kategori-img">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>

        <!-- Search Bar -->
        <form class="d-flex flex-grow-1 mx-3">
            <input class="form-control border-start-0" type="search" placeholder="cari di GitalBox" aria-label="Search">
        </form>



        <!-- Keranjang -->
<div class="keranjang-container position-relative">
    <a href="{{ route('cart.index') }}" class="keranjang-icon" id="cartIcon">
        <i class="fas fa-shopping-cart"></i>
        @if(isset($cartItems) && $cartItems->count() > 0)
            <span id="cart-count" class="badge bg-danger">{{ $cartItems->count() }}</span>
        @endif
    </a>

    <!-- Floating Dropdown -->
    <div id="cartDropdown" class="keranjang-dropdown p-3 shadow rounded bg-white">
    <div id="cart-items-container">
    </div>
    </div>
</div>
       
       




<span class="text-muted mx-5">|</span>

<!-- Profil Dropdown -->
@auth
<div class="profile-container">
    <span class="profile-icon" id="profile-icon">
        @if (Auth::check())  {{-- Periksa apakah user sudah login --}}
            {{ Auth::user()->name }}  {{-- Tampilkan nama user --}}
        @else
            Guest  {{-- Tampilkan teks default jika belum login --}}
        @endif
</span>

    <!-- Floating Dropdown -->
    <div id="profile-dropdown" class="profile-dropdown">
        <ul>
            <li>
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="fas fa-user-edit me-2"></i> Edit Profil
                </a>
            </li>
            <li>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
                <span href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </span>
            </li>
        </ul>
    </div> 
</div>
@endauth

@guest
<!-- Jika user belum login, tampilkan tombol login -->
<a href="{{ route('login') }}" class="login-btn" style="margin-right:20px;">Login</a>
<a href="{{ route('register') }}" class="daftar-btn">Register</a>
@endguest


       
</div>
</nav>
