@extends('HalamanHome.layouts')

@section('title', 'Contoh Halaman')

@section('content')

@foreach ($products as $product)
<div class="col-md-4 mb-4 product-card" data-categories="{{ $product->categories && $product->categories->isNotEmpty() ? $product->categories->pluck('id')->implode(',') : '' }}"
data-brand="{{ $product->brand->id ?? '' }}">
    
<div class="card h-100 product-clickable" data-url="{{ route('products.show', $product->id) }}">
        @if ($product->image1)
        <img src="{{ asset('storage/' . $product->image1) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
        @else
        <img src="placeholder_image.jpg" class="card-img-top" alt="No Image" style="height: 180px; object-fit: cover;">
        @endif
        <div class="card-body d-flex flex-column">
            <strong class="card-title font-bold">{{ $product->name }}</strong>
            <p class="card-text text-success font-weight-bold">Rp {{ number_format($product->price) }}</p>
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

@endsection