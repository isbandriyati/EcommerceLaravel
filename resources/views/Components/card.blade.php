<div class="card">
    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
    <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
        <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">Detail</a>
        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-warning"><i class="bi bi-cart-plus"></i></a>
        <a href="{{ route('cart.buy', $product->id) }}" class="btn btn-success">Beli</a>
    </div>
</div>
