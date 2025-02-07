<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Produk Baru
        </h2>
    </x-slot>

    <div class="container mt-5">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">Formulir Tambah Produk</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Nama Produk -->
                    <tr>
                        <td class="col-md-2">
                            <label for="name" class="form-label">Nama Produk</label>
                        </td>
                        <td class="col-md-6">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    <!-- Deskripsi Produk -->
                    <tr>
                        <td class="col-md-2">
                            <label for="description" class="form-label">Deskripsi Produk</label>
                        </td>
                        <td class="col-md-6">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    <!-- Harga Produk -->
                    <tr>
                        <td class="col-md-2">
                            <label for="price" class="form-label">Harga Produk</label>
                        </td>
                        <td class="col-md-6">
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    <!-- Stock Produk -->
                    <tr>
                        <td class="col-md-2">
                            <label for="stock" class="form-label">Stock Produk</label>
                        </td>
                        <td class="col-md-6">
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    <!-- Kategori Produk -->
                    <tr>
                        <td class="col-md-2">
                            <label for="category_id" class="form-label">Kategori Produk</label>
                        </td>
                        <td class="col-md-6">
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    <!-- Gambar Produk -->
                    <tr>
                        <td class="col-md-2">
                            <label for="image" class="form-label">Gambar Produk</label>
                        </td>
                        <td class="col-md-6">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    <!-- Submit Button -->
                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" class="btn btn-success btn-lg">Simpan Produk</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</x-app-layout>
