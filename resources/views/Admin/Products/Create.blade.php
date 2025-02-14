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
                        <td class="col-md-2"><label for="name" class="form-label">Nama Produk</label></td>
                        <td class="col-md-6">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </td>
                    </tr>

                    <!-- Deskripsi Produk -->
                    <tr>
                        <td class="col-md-2"><label for="description" class="form-label">Deskripsi Produk</label></td>
                        <td class="col-md-6">
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </td>
                    </tr>

                    <!-- Prosessor -->
                    <tr>
                        <td class="col-md-2"><label for="prosesor" class="form-label">Prosesor</label></td>
                        <td class="col-md-6">
                        <div id="prosesor-container">
                            @if(old('prosesor', isset($product) ? json_decode($product->prosesor, true) : []))
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
            @if(old('memory_options', isset($product) ? json_decode($product->memory_options, true) : []))
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
                        <td class="col-md-2"><label for="price" class="form-label">Harga Produk</label></td>
                        <td class="col-md-6">
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price') }}" required>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </td>
                    </tr>

                    <!-- Stock Produk -->
                    <tr>
                        <td class="col-md-2"><label for="stock" class="form-label">Stock Produk</label></td>
                        <td class="col-md-6">
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock') }}" required>
                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </td>
                    </tr>

                    <!-- Kategori Produk -->
                    <tr>
                        <td class="col-md-2"><label for="category_id" class="form-label">Kategori Produk</label></td>
                        <td class="col-md-6">
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </td>
                    </tr>

                    <!-- Brand Produk -->
                    <tr>
                    <td class="col-md-2"><label for="brand_id" class="form-label">Brand Produk</label></td>
                    <td class="col-md-6">
                        <select class="form-select @error('brand_id') is-invalid @enderror" 
                            id="brand_id" name="brand_id" required>
                                <option value="">Pilih Brand</option>
                                 @foreach($brands as $brand)
                                     <option value="{{ $brand->id }}" 
                                             {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                         {{ $brand->name }}
                                        </option>
                                  @endforeach
                               </select>
                                @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                           </td>
                        </tr>
                    <!-- Gambar Produk -->
                    <tr>
                        <td class="col-md-2"><label for="images" class="form-label">Gambar Produk</label></td>
                        <td class="col-md-6">
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('imageInput').click()">
                                <i class="bi bi-plus-circle"></i> Tambah Gambar
                            </button>
                            <input type="file" id="imageInput" name="images[]" class="d-none" accept="image/*" multiple 
                                   onchange="previewImages()">

                            <!-- Preview Gambar -->
                            <div id="imagePreview" class="mt-3 d-flex flex-wrap gap-2"></div>

                            @error('images') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

    <!-- JavaScript Preview Gambar -->
    <script>
        function previewImages() {
            var preview = document.getElementById('imagePreview');
            var files = document.getElementById('imageInput').files;
            preview.innerHTML = '';

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.marginRight = '10px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(files[i]);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('tambahProsesor').addEventListener('click', function () {
        let container = document.getElementById('prosesor-container');
        let div = document.createElement('div');
        div.classList.add('input-group', 'mb-2');
        div.innerHTML = `
            <input type="text" class="form-control" name="prosesor[]" placeholder="Masukkan prosesor">
            <button type="button" class="btn btn-danger remove-prosesor">X</button>
        `;
        container.appendChild(div);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-prosesor')) {
            e.target.parentElement.remove();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('tambahMemory').addEventListener('click', function () {
        let container = document.getElementById('memory-container');
        let div = document.createElement('div');
        div.classList.add('input-group', 'mb-2');
        div.innerHTML = `
            <input type="text" class="form-control" name="memory_options[]" placeholder="Masukkan kapasitas memory">
            <button type="button" class="btn btn-danger remove-memory">X</button>
        `;
        container.appendChild(div);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-memory')) {
            e.target.parentElement.remove();
        }
    });
});
    </script>
</x-app-layout>
