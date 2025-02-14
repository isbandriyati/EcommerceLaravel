@props(['categories', 'carts'])

<nav class="navbar navbar-expand-lg shadow-sm fixed-top py-3 custom-navbar">
    <div class="container align-items-center">
        
        <!-- Logo -->
        <a class="navbar-brand fw-bold fs-3" href="#">GitalBox</a>

        <!-- Kategori -->
        <div class="cart-container">
            <a href="#" class="kategori-icon">Kategori</a>

            <!-- Floating Dropdown -->
            <div id="cart-dropdown" class="cart-dropdown">
                <ul>
                @foreach ($categories as $category)
                    <li>
                        <a class="dropdown-item kategori-item" href="{{ route('category.product', $category->id) }}">
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
        <div class="cart-container">
            <a href="#" class="keranjang-icon" id="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count" class="badge bg-danger d-none">0</span>
            </a>

            <!-- Floating Dropdown -->
            <div id="cart-dropdown" class="cart-dropdown">
                <!-- Jika Keranjang Kosong -->
                <div id="empty-cart" class="text-center space">
                    <div>
                    <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" alt="Empty Cart" class="cart-image">
                    <p class="fw-bold text-muted">Wah, keranjang belanjamu kosong</p>
                    <p class="text-muted small">Yuk, isi dengan barang-barang impianmu!</p>
                    </div>
                    <a href="#" class="btn btn-outline-success">Mulai Belanja</a>
                </div>

                <!-- Jika Ada Produk -->
                <div id="cart-items" class="d-none">
                    <ul class="list-unstyled mb-2">
                        <li>Produk 1 - Rp 100.000</li>
                        <li>Produk 2 - Rp 200.000</li>
                    </ul>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="text-muted small" id="item-count">2 barang</span>
                        <a href="/cart" class="btn btn-danger btn-sm">Lihat Keranjang</a>
                    </div>
                </div>
            </div>
        </div>



<span class="text-muted mx-5">|</span>

<!-- Profil Dropdown -->
<div class="profile-container">
    <a href="#" class="profile-icon" id="profile-icon">
        <img src="{{ asset(Auth::user()->profile_photo_path ?? 'default-profile.png') }}" 
             alt="Profile" class="profile-img">
    </a>

    <!-- Floating Dropdown -->
    <div id="profile-dropdown" class="profile-dropdown">
        <ul>
            <li>
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="fas fa-user-edit me-2"></i> Edit Profil
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>

       
</div>
</nav>
