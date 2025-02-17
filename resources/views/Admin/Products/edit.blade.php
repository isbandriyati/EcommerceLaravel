<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Produk
        </h2>
    </x-slot>

    <div class="container mt-5">
        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Menyatakan bahwa ini adalah form update -->

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">Formulir Edit Produk</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Nama Produk -->
                    <tr>
                        <td class="col-md-3">
                            <label for="name" class="form-label">Nama Produk</label>
                        </td>
                        <td>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    <!-- Deskripsi Produk -->
                    <tr>
                        <td class="col-md-3">
                            <label for="description" class="form-label">Deskripsi Produk</label>
                        </td>
                        <td>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    <!-- Prosessor -->
                    <tr>
                        <td class="col-md-2"><label for="prosesor" class="form-label">Prosesor</label></td>
                        <td class="col-md-6">
                        <div id="prosesor-container">
                        @php 
                        $oldProsesor = old('prosesor', isset($product) ? json_decode($product->prosesor ?? '[]', true) : []);
                        @endphp
                        @if(is_array($oldProsesor) && count($oldProsesor) > 0)
                                @foreach(old('prosesor', json_decode($product->prosesor ?? '[]', true)) as $index => $prosesor)
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="prosesor[]" value="{{ $prosesor }}" placeholder="Masukkan prosesor">
                                                    <button type="button" class="btn btn-danger remove-prosesor">X</button>
                                    </div>
                                @endforeach
                                        @else
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="prosesor[]" placeholder="Masukkan prosesor">
                                    <button type="button" class="btn btn-primary" id="tambahProsesor">+</button>
                                </div>
                            @endif
                        </div>
                        @error('prosesor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </td>
                    </tr>                  


                    <!-- Memory -->
                    <tr>
    <td class="col-md-2"><label for="memory" class="form-label">Memory</label></td>
    <td class="col-md-6">
        <div id="memory-container">
        @php 
            $oldMemory = old('memory_options', isset($product) ? json_decode($product->memory ?? '[]', true) : []);
        @endphp
            @if(is_array($oldMemory) && count($oldMemory) > 0)
                @foreach(old('memory_options', json_decode($product->memory_options ?? '[]', true)) as $index => $memory)
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="memory_options[]" value="{{ $memory }}" placeholder="Masukkan kapasitas memory">
                        <button type="button" class="btn btn-danger remove-memory">X</button>
                    </div>
                @endforeach
            @else
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="memory_options[]" placeholder="Masukkan kapasitas memory">
                    <button type="button" class="btn btn-primary" id="tambahMemory">+</button>
                </div>
            @endif
        </div>
        @error('memory_options') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </td>
</tr>
    

                    <!-- Harga Produk -->
                    <tr>
                        <td class="col-md-3">
                            <label for="price" class="form-label">Harga Produk</label>
                        </td>
                        <td>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    <!-- Kategori Produk -->
                    <tr>
                        <td class="col-md-3">
                            <label for="category_id" class="form-label">Kategori Produk</label>
                        </td>
                        <td>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                            <label for="images" class="form-label">Gambar Produk</label>
                        </td>
                        <td class="col-md-6">
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('imageInput').click()">
                                <i class="bi bi-plus-circle"></i> Tambah Gambar
                            </button>
                            <input type="file" id="imageInput" name="images[]" class="d-none" accept="image/*" multiple>

                            <!-- Preview Gambar -->
                            <div id="imagePreview" class="mt-3 d-flex flex-wrap gap-2"></div> 

                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <!-- Stock Produk -->
                    <tr>
                        <td class="col-md-3">
                            <label for="stock" class="form-label">Stock Produk</label>
                        </td>
                        <td>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    <!-- Submit Button -->
                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" class="btn btn-warning">Update Produk</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</x-app-layout>
