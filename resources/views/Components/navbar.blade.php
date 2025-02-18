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
<div class="keranjang-container position-relative">
    <a href="{{ route('cart.index') }}" class="keranjang-icon" id="cartIcon">
        <i class="fas fa-shopping-cart"></i>
        @if(isset($cartItems) && $cartItems->count() > 0)
            <span id="cart-count" class="badge bg-danger">{{ $cartItems->count() }}</span>
        @endif
    </a>

    <!-- Floating Dropdown -->
    <div id="cartDropdown" class="keranjang-dropdown p-3 shadow rounded bg-white">
        @if(isset($cartItems) && $cartItems->count() > 0)
            <!-- Jika Ada Produk -->
            <div id="cart-items-container">
                <ul class="list-unstyled">
                    @foreach ($cartItems as $item)
                        <li class="d-flex align-items-center py-2">
                            <img src="{{ asset('storage/' . $item->product->image1) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover">
                            <div class="ms-3">
                                <p class="mb-1 fw-bold">{{ $item->product->name ?? 'Produk tidak ditemukan' }}</p>
                                <p class="mb-1 text-muted">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                <p class="mb-1">Qty: {{ $item->quantity }}</p>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <hr class="dropdown-divider">
                <div class="text-center">
                    <a class="btn btn-primary w-100" href="{{ route('cart.index') }}">Lihat Semua</a>
                </div>
            </div>
        @else
            <!-- Jika Keranjang Kosong -->
            <div class="text-center p-4">
                <img src="{{ asset('images/keranjang-kosong.png') }}" alt="Keranjang Kosong" class="w-50 mx-auto d-block">
                <h5 class="fw-bold mt-3">Wah, keranjang belanjamu kosong</h5>
                <p class="text-muted">Yuk, isi dengan barang-barang impianmu!</p>
                <a href="{{ route('products.index') }}" class="btn btn-outline-success">Mulai Belanja</a>
            </div>
        @endif
    </div>
</div>
       
       




<span class="text-muted mx-5">|</span>

<!-- Profil Dropdown -->
@auth
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
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
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
