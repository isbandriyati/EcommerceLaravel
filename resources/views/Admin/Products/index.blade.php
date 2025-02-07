<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">Daftar Produk</h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <a href="{{ route('product.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Tambah Produk</a>
        
        <div class="mt-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Nama</th>
                        <th class="border px-4 py-2">Deskripsi</th>
                        <th class="border px-4 py-2">Gambar</th>
                        <th class="border px-4 py-2">Stok</th>
                        <th class="border px-4 py-2">Harga</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td class="border px-4 py-2">{{ $product->id }}</td>
                        <td class="border px-4 py-2">{{ $product->name }}</td>
                        <td class="border px-4 py-2">{{ $product->description }}</td>
                        <td class="border px-4 py-2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16">
                        </td>
                        <td class="border px-4 py-2">{{ $product->stock }}</td>
                        <td class="border px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('product.edit', $product->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</a>
                            
                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
