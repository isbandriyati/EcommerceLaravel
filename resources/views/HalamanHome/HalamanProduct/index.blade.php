@extends('HalamanHome.layouts')

@section('title', 'Contoh Halaman')

@section('content')

<div class="container-AllProduct">
    <div class="row">
        <h4>All Product</h4>

        <form id="filter-form" action="{{ route('products.index') }}" method="GET">
            <div class="col-md-3">
                <div class="filter-box p-4 bg-gray-900 text-white rounded">
                    <h2 class="font-bold text-lg">Categories</h2>
                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                        <li>
                            <label>
                                <input type="checkbox" name="categories[]" id="category-{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, request()->categories ?? []) ? 'checked' : '' }} >
                                {{ $category->name }}
                            </label>
                        </li>
                        @endforeach
                    </ul>

                    <h2 class="mt-4 font-bold text-lg">Filter By Brand</h2>
                    <ul class="list-unstyled">
                        @foreach($brands as $brand)
                        <li>
                            <input type="checkbox" id="brand-{{ $brand->id }}" name="brands[]" value="{{ $brand->id }}" {{ in_array($brand->id, request()->brands ?? []) ? 'checked' : '' }}>
                            <label for="brand-{{ $brand->id }}">{{ $brand->name }}</label>
                        </li>
                        @endforeach
                    </ul>

                    <h2 class="mt-4 font-bold text-lg">Filter By Price</h2>
                    <div class="d-flex flex-column gap-2">
                        <input type="range" id="priceRange" min="1" max="99999" value="{{ request()->price ?? 99999 }}" class="form-range" name="price">
                        <span id="priceValue" class="bg-black text-white p-2 text-center">{{ request()->price ?? 99999 }}</span>
                        <button type="submit">Apply</button>
                    </div>     
                       
</div>
</div>

        <div class="col-md-9" id="product-list">
            <div class="row mt-3">
                @include('HalamanHome.HalamanProduct.product_list')
            </div>
            <div class="pagination-container">
                {{ $products->links() }}
            </div>
        </div>

</form>


@endsection
