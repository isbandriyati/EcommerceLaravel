@extends('HalamanHome.layouts')

@section('title', 'Contoh Halaman')

@section('content')
<x-carousel />
    
<!-- Kategori -->
<div style="border-top: 2px solid #000; border-bottom: 2px solid #000;" class="bg-white py-3"> 
    <div class="container-OurKategori">
        <h5 class="text-white">Browse by category</h5>
        <div class="d-flex flex-wrap justify-content-start">
            @foreach ($categories as $category)
            <div class="p-2">
                <div class="category-item">
                <a href="{{ route('category.product', $category->id) }}" class="text-decoration-none">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-image" style="max-width:100%;">
                    <div class="category-title text-black">{{ $category->name }}</div>
                    </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


<div class="container mt-5">
    <div class="row g-4">
        <!-- Card 1 (Besar) -->
        <div class="col-md-6">
            <div class="card" style="height: 43vh;">
                <div class="card-body">
                    <span class="text-new">NEW</span>
                    <h5 class="card-title mt-2">TCL 43" S5400A FHD/HD Smart TV</h5>
                    <p class="card-text">Dengan ukuran layar hingga 43" Rp 3.199.000</p>
                    <a href="#" class="btn btn-primary">Check out now</a>
                </div>
                <img src="{{ asset('storage/images/tvsamsung.jpg') }}" alt="TCL 43 Smart TV">
            </div>
        </div>

        <!-- Card 2 dan Card 3 (Kecil) -->
        <div class="col-md-6">
            <div class="row g-4">
                <!-- Card 2 -->
                <div class="col-md-12">
                    <div class="card card-horizontal" style="height: 20vh;">
                        <div class="card-body">
                            <span class="text-new">NEW</span>
                            <h5 class="card-title mt-2">Samsung Galaxy Z Fold6</h5>
                            <p class="card-text">Berkekuatan CPU: Snapdragon 8 Gen 3 For Galaxy Rp 24.499.000</p>
                            <a href="#" class="btn btn-primary">Check out now</a>
                        </div>
                        <img src="{{ asset('storage/images/samsungultra.jpg') }}" alt="Samsung Galaxy Z Fold6">
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-12">
                    <div class="card card-horizontal" style="height: 20vh;">
                        <div class="card-body">
                            <span class="text-new">NEW</span>
                            <h5 class="card-title mt-2">Apple MacBook Pro M4 14 inci (2024)</h5>
                            <p class="card-text">MacBook Pro 14 inci dengan chip M4 menghadirkan performa spektakuler Rp 27.999.000</p>
                            <a href="#" class="btn btn-primary">Check out now</a>
                        </div>
                        <img src="{{ asset('storage/images/macbook.jpg') }}" alt="Apple MacBook Pro M4">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="feature-cards">
    <div class="feature-card">
        <i class="bi bi-truck"></i>
        <h4>Free Shipping</h4>
        <p>Enjoy free shipping on all orders.</p>
    </div>
    <div class="feature-card">
        <i class="bi bi-currency-dollar"></i>
        <h4>Guarantee</h4>
        <p>Get the best quality products guaranteed.</p>
    </div>
    <div class="feature-card">
        <i class="bi bi-wallet"></i>
        <h4>100% Payment Secure</h4>
        <p>Your payment is 100% secure with us.</p>
    </div>
    <div class="feature-card">
        <i class="bi bi-telephone-inbound"></i>
        <h4>Support 24/7</h4>
        <p>Our team is here to help you anytime.</p>
    </div>
</div>

<div class="container-countdown">
<div class="countdown-banner">
        <div class="content">
            <p class="badge">Don't Miss!</p>
            <h1>Enhance Your<br>Music Experience</h1>
            <div class="timer">
                <div class="time-block">
                    <span id="days">15</span>
                    <p>Day</p>
                </div>
                <div class="time-block">
                    <span id="hours">10</span>
                    <p>Hrs</p>
                </div>
                <div class="time-block">
                    <span id="minutes">56</span>
                    <p>Min</p>
                </div>`
                <div class="time-block">
                    <span id="seconds">54</span>
                    <p>Sec</p>
                </div>
            </div>
            <a href="#" class="btn">Check it Out!</a>
        </div>
        <div class="image">
            <img src="{{ asset('storage/images/airpods.png') }}" alt="Headphone">
        </div>
    </div>
</div>



<!-- Product Terbaru -->
<div class="container-product">
<div class="d-flex justify-content-between align-items-center mt-5">
        <h3 class="text-left">Cek Yang Terbaru</h3>
        <a href="{{ route('products.index') }}" class="btn btn-primary">
            View All Products
        </a>
    </div>
    <div class="row card-home">
        @foreach ($products as $product)
            <div class="col-md-2">
                <div class="card mt-4 h-100 d-flex flex-column" 
                     onclick="window.location.href='{{ route('products.show', $product->id) }}'" 
                     style="cursor: pointer;">
                    <img src="{{ asset('storage/' . $product->image1) }}" 
                         class="card-img-top" 
                         alt="{{ $product->name }}" 
                         style="height: 200px; object-fit: cover;">

                    <div class="card-body d-flex flex-column">
                        <strong class="card-title font-bold">{{ $product->name }}</strong>

                        <!-- Harga -->
                        <p class="card-text text-success font-weight-bold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <!-- Stok -->
                        <p class="card-text mt-auto">
                            <strong>Stok: </strong>
                            @if($product->stock > 0)
                                <span class="text-success">{{ $product->stock }} tersedia</span>
                            @else
                                <span class="text-danger">Habis</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>




@endsection
