@extends('HalamanHome.layouts')

@section('title', 'Product')

@section('content')

<div class="container mt-5">
    <h3>Browse by Category</h3>
    <div class="d-flex flex-wrap">
        @foreach ($categories as $category)
            <a href="{{ route('category.product', $category->id) }}" class="category-item">
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-image">
                <div class="category-title">{{ $category->name }}</div>
            </a>
        @endforeach
    </div>

    <div class="container-product">
    <h3 class="text-left mt-5">Explore our Product</h3>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-2">
                <div class="card mt-5" onclick="window.location.href='{{ route('product.show', $product->id) }} ' " style="cursor: pointer;">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 50) }}</p> <!-- Deskripsi singkat -->
                        <p class="card-text">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        
                        <!-- Menampilkan stok -->
                        <p class="card-text">
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
