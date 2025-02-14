<div class="max-w-4xl mx-auto py-6">
        <h2 class="text-xl font-bold">Keranjang Belanja</h2>

        @if (session('success'))
            <div class="bg-green-100 p-2 rounded text-green-700">{{ session('success') }}</div>
        @endif

        @if (empty($cart))
            <p class="mt-4">Keranjang belanja kosong.</p>
        @else
            <table class="w-full mt-4 border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Nama Produk</th>
                        <th class="p-2 border">Harga</th>
                        <th class="p-2 border">Jumlah</th>
                        <th class="p-2 border">Total</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $id => $item)
                        <tr class="text-center">
                            <td class="p-2 border">{{ $item['name'] }}</td>
                            <td class="p-2 border">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="p-2 border">
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 text-center">
                                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Update</button>
                                </form>
                            </td>
                            <td class="p-2 border">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            <td class="p-2 border">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">Kosongkan Keranjang</button>
                </form>
            </div>
        @endif
    </div>