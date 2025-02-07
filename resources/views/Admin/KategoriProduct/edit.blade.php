<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Kategori') }}
    </h2>
</x-slot>

<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-semibold">Edit Kategori Produk</h2>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="mt-4" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium">Nama Kategori</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium">Gambar Kategori</label>
            <input type="file" name="image" id="image" class="mt-1 block w-full border-gray-300 rounded-md">
            @if($category->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="Kategori Image" class="w-32 h-32 object-cover">
                </div>
            @endif
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

</x-app-layout>
