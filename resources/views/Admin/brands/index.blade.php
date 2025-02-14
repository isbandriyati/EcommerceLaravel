<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Brands') }}
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

    <h2 class="text-2xl font-semibold">Daftar Brand</h2>
    
    <div class="mb-4 text-right">
        <a href="{{ route('brands.create') }}" class="btn btn-primary">Tambah Brand</a>
    </div>

    <table class="min-w-full table-auto border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Nama Brand</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
                <tr>
                    <td class="px-4 py-2 border">{{ $brand->id }}</td>
                    <td class="px-4 py-2 border">{{ $brand->name }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('brands.edit', $brand->id) }}" class="text-blue-500">Edit</a> |
                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500" onclick="return confirm('Apakah Anda yakin ingin menghapus brand ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-app-layout>
