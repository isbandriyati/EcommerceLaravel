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
                        <th class="border px-4 py-2">Prosesor</th>
                        <th class="border px-4 py-2">Memory</th>
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
                        @php
                            $prosesor = $product->prosesor ?? '[]';
                            $prosesor = is_string($prosesor) ? json_decode($prosesor, true) : $prosesor;
                        @endphp
                        {{ is_array($prosesor) && !empty($prosesor) ? implode(', ', $prosesor) : 'Tidak ada data' }}
                    </td>

                    <td class="border px-4 py-2">
                        @php
                            $memory = $product->memory ?? '[]';
                            $memory = is_string($memory) ? json_decode($memory, true) : $memory;
                        @endphp
                        {{ is_array($memory) && !empty($memory) ? implode(', ', $memory) : 'Tidak ada data' }}
                    </td>

                        <td class="border px-4 py-2">
                        @if ($product->image1)
                            <img src="{{ asset('storage/' . $product->image1) }}" alt="Image 1" class="w-16 h-16">
                        @endif
                        @if ($product->image2)
                            <img src="{{ asset('storage/' . $product->image2) }}" alt="Image 2" class="w-16 h-16">
                        @endif
                        @if ($product->image3)
                            <img src="{{ asset('storage/' . $product->image3) }}" alt="Image 3" class="w-16 h-16">
                        @endif
                        @if ($product->image4)
                            <img src="{{ asset('storage/' . $product->image4) }}" alt="Image 4" class="w-16 h-16">
                        @endif
                        </td>
                        <td class="border px-4 py-2">{{ $product->stock }}</td>
                        <td class="border px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2 flex items-center justify-center space-x-2">
                            <a href="{{ route('product.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
