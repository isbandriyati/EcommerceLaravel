@extends('HalamanHome.layouts')

@section('title', 'Contoh Halaman')

@section('content')

<div class="container-AllProduct"> 
    <div class="row">
        <h4>All Product</h4>
        <!-- Filter Kategori -->
        <div class="col-md-3" id="filter-form">
            <div class="filter-box p-4 bg-gray-900 text-white rounded">
                <h2 class="font-bold text-lg">Categories</h2>
                <ul class="list-unstyled">
                    @foreach($categories as $category)
                        <li>
                            <input type="checkbox" id="category-{{ $category->id }}" name="categories[]" value="{{ $category->id }}">
                            <label for="category-{{ $category->id }}">{{ $category->name }}</label>
                        </li>
                    @endforeach
                </ul>

                <h2 class="mt-4 font-bold text-lg">Filter By Brand</h2>
                <ul class="list-unstyled">
                    @foreach($brands as $brand)
                        <li>
                            <input type="checkbox" id="brand-{{ $brand->id }}" name="brands[]" value="{{ $brand->id }}">
                            <label for="brand-{{ $brand->id }}">{{ $brand->name }}</label>
                        </li>
                    @endforeach
                </ul>

                <h2 class="mt-4 font-bold text-lg">Filter By Price</h2>
                <div class="d-flex flex-column gap-2">
                    <input type="range" id="priceRange" min="1" max="99999" value="1" class="form-range">
                    <span id="priceValue" class="bg-black text-white p-2 text-center">1</span>
                </div>
            </div>
        </div>

        <!-- Produk -->
        <div class="col-md-9">
            <div class="row mt-3">
                @foreach ($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 product-card" 
                            onclick="window.location.href='{{ route('products.show', $product->id) }}'" 
                            style="cursor: pointer;">
                            <img src="{{ asset('storage/' . $product->image1) }}" 
                                class="card-img-top" 
                                alt="{{ $product->name }}" 
                                style="height: 180px; object-fit: cover;">

                            <div class="card-body d-flex flex-column">
                                <strong class="card-title font-bold">{{ $product->name }}</strong>
                                <p class="card-text text-success font-weight-bold">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
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
    </div>
</div>


@endsection
