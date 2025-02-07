@extends('HalamanHome.layouts')

@section('title', 'Product')

@section('content')



    <div class="container-product" style="margin-top: 200px;">
    <h3 class="text-left">{{ $category->name }}</h3>
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
                        <p class="card-title">{{ $product->name }}</p>

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
