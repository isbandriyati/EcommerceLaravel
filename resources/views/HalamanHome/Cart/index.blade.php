<head>

<style>
/* css keranjang */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

thead {
    background-color: #4A90E2;
    color: white;
    text-transform: uppercase;
}

th, td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

th {
    font-weight: bold;
}

tr:hover {
    background-color: #f5f5f5;
}

img {
    border-radius: 8px;
}

input[type="number"] {
    width: 50px;
    padding: 4px;
    border: 1px solid #ccc;
    border-radius: 4px;
    text-align: center;
}

button {
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.bg-blue-500 {
    background-color: #4A90E2;
}

.bg-blue-500:hover {
    background-color: #357ABD;
}

.bg-red-500 {
    background-color: #E24A4A;
}

.bg-red-500:hover {
    background-color: #C0392B;
}

.bg-gray-500 {
    background-color: #6c757d;
}

.bg-gray-500:hover {
    background-color: #5a6268;
}

.mt-4 {
    margin-top: 16px;
}

.rounded {
    border-radius: 6px;
}

.text-white {
    color: white;
}

.text-center {
    text-align: center;
}

.w-16 {
    width: 4rem;
}

.wa-checkout {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.wa-checkout a {
    background-color: #25D366;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.3s ease;
}

.wa-checkout a:hover {
    background-color: #1EBE5D;
}

</style>



</head>





@if ($cartItems->isEmpty())
    <p class="mt-4">Keranjang belanja kosong.</p>
@else
    <table class="w-full mt-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Gambar Produk</th>
                <th class="p-2 border">Nama Produk</th>
                <th class="p-2 border">Harga</th>
                <th class="p-2 border">Jumlah</th>
                <th class="p-2 border">Total</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
                <tr class="text-center">
                <td class="p-2 border">
                    <img src="{{ asset('storage/' . $item->product->image1) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover mx-auto">
                </td>
                    <td class="p-2 border">{{ $item->product->name ?? 'Produk tidak ditemukan' }}</td>
                    <td class="p-2 border">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                    <td class="p-2 border">
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 text-center">
                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Update</button>
                        </form>
                    </td>
                    <td class="p-2 border">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                    <td class="p-2 border">
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                        </form>
                        <div class="wa-checkout mt-4">
                            <a href="{{ route('cart.checkout.wa') }}" class="bg-green-500 text-white px-4 py-2 rounded">
                                Checkout
                            </a>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">Kosongkan Keranjang</button>
        </form>
    </div>
@endif
