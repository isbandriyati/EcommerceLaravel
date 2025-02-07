@extends('HalamanHome.layouts')

@section('title', 'Contoh Halaman')

@section('content')
<x-carousel />
    
<!-- Kategori -->
<div style="border-top: 2px solid #000; border-bottom: 2px solid #000;"> 
    <div class="container-kategori">
        <h5>Browse by category</h5>
        <div class="d-flex flex-wrap justify-content-start">
            @foreach ($categories as $category)
            <div class="p-2">
                <div class="category-item">
                <a href="{{ route('category.product', $category->id) }}" class="text-decoration-none">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-image">
                    <div class="category-title">{{ $category->name }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>



<div class="banner">
<h3> Enchance your</h3>
<h3> Music Experience</h3>
<a href="#" class="btn btn-primary btn">Check it out now</a>
    <img src="{{ asset('storage/images/airpods.png') }}" class="gambar" alt="banner">
    
</div>



<!-- Product Terbaru -->
<div class="container-product">
    <h3 class="text-left mt-5">Explore our Product</h3>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-2">
                <div class="card mt-4 h-100 d-flex flex-column" 
                     onclick="window.location.href='{{ route('product.show', $product->id) }}'" 
                     style="cursor: pointer;">
                    <img src="{{ asset('storage/' . $product->image) }}" 
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
