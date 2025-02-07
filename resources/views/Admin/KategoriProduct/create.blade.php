<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kategori') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8">
        <!-- Menampilkan pesan sukses atau error -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-2xl font-semibold">Tambah Kategori Produk</h2>

        <form action="{{ route('categories.store') }}" method="POST" class="mt-4" enctype="multipart/form-data">
            @csrf
            <!-- Input Nama Kategori -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Nama Kategori</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>

            <!-- Input Gambar Kategori -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium">Tambahkan Gambar</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full border-gray-300 rounded-md" accept="image"> 
            </div>

            

            <!-- Tombol Simpan -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Simpan') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
