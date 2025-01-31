@extends('layouts.app')

@section('content')
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

    <h2 class="text-2xl font-semibold">Kategori Produk</h2>
    
    <div class="mb-4 text-right">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
    </div>

    <table class="min-w-full table-auto">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Jumlah Produk</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td class="px-4 py-2 border">{{ $category->id }}</td>
                    <td class="px-4 py-2 border">{{ $category->name }}</td>
                    <td class="px-4 py-2 border">{{ $category->products_count }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-500">Edit</a> |
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
