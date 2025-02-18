@extends('HalamanHome.layouts')

@section('title', 'Contoh Halaman')

@section('content')



<div class="container-showproduct">
    <div class="row">
        <!-- Gambar Produk -->
        <div class="col-md-4">
    <!-- Carousel Gambar Utama -->
    <div id="productCarousel" class="carousel slide">
        <div class="carousel-inner">
            @foreach([$product->image1, $product->image2, $product->image3, $product->image4] as $index => $image)
                @if ($image)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img id="mainImage" src="{{ asset('storage/' . $image) }}" class="d-block w-100 rounded shadow-sm" style="max-height: 350px; object-fit: cover;" alt="Product Image {{ $index + 1 }}">
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Thumbnail Container -->
    <div class="d-flex justify-content-center mt-2">
        @foreach([$product->image1, $product->image2, $product->image3, $product->image4] as $index => $image)
            @if ($image)
                <img src="{{ asset('storage/' . $image) }}" class="thumbnail img-thumbnail mx-1 {{ $index == 0 ? 'active' : '' }}" style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;" onclick="changeImage('{{ asset('storage/' . $image) }}', this)">
            @endif
        @endforeach
    </div>
</div>

        <!-- Deskripsi dan Harga -->
        <div class="col-md-4">
    <div class="product-details text-start p-3">
        <h2 class="fw-bold">{{ $product->name }}</h2>
        <p class="text-muted">Brand: <span class="fw-semibold">{{ $product->brand->name ?? 'Unknown' }}</span></p>     
        <!-- Garis Pemisah -->
        <hr class="text-muted">
        <p class="product-description">{{ $product->description }}</p>
        <h4 class="text-danger fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
    </div>
</div>

        <!-- Box Pilih Varian -->
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h5 class="mb-3">Pilih Varian</h5>

                @if(!empty($product->prosesor))
    @php $prosesorOptions = json_decode($product->prosesor, true); @endphp
    @if(is_array($prosesorOptions))
        <div class="mb-3">
            <label class="form-label small-label">Prosesor:</label>
            <div class="d-flex flex-column gap-2">
                @foreach($prosesorOptions as $prosesor)
                    <input type="radio" class="btn-check" name="prosesor" id="prosesor-{{ $loop->index }}" value="{{ $prosesor }}" autocomplete="off">
                    <label class="btn btn-outline-secondary option-box small-box" for="prosesor-{{ $loop->index }}">{{ $prosesor }}</label>
                @endforeach
            </div>
        </div>
    @endif
@endif

<!-- Pilihan Memory -->
@if(!empty($product->memory))
    @php $memoryOptions = json_decode($product->memory, true); @endphp
    @if(is_array($memoryOptions))
        <div class="mb-3">
            <label class="form-label small-label">Memory:</label>
            <div class="d-flex gap-2">
                @foreach($memoryOptions as $memory)
                    <input type="radio" class="btn-check" name="memory" id="memory-{{ $loop->index }}" value="{{ $memory }}" autocomplete="off">
                    <label class="btn btn-outline-secondary option-box small-box" for="memory-{{ $loop->index }}">{{ $memory }}</label>
                @endforeach
            </div>
        </div>
    @endif
@endif

                <!-- Input Jumlah -->
                <div class="mb-3">
                    <label for="quantity" class="form-label">Jumlah:</label>
                    <div class="input-group">
                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                        <input type="number" id="quantity" name="quantity" class="form-control text-center" value="1" min="1">
                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                    </div>
                </div>

                <!-- Tombol Add to Cart -->
                @if(Auth::check()) 
                <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart" onsubmit="toggleLoading(this)">
                @csrf
                    <input type="hidden"  name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                    <span class="button-text">Masukkan Keranjang</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </form>
                <div id="product-added-alert" class="alert alert-success d-none" role="alert">
                Produk berhasil ditambahkan ke keranjang!
                </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">Login untuk Belanja</a>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
