<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('HalamanHome.Cart.index', compact('cartItems'));
    }

    /**
     * Menambahkan produk ke keranjang
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);

        $cartItem = Cart::firstOrNew([
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);

        $cartItem->quantity += $request->quantity;
        $cartItem->save();

        return response()->json([
            'message' => 'Item berhasil ditambahkan ke keranjang!',
            'cartCount' => Cart::where('user_id', $user->id)->sum('quantity')
        ]);
    }

    /**
     * Memperbarui jumlah produk dalam keranjang
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:carts,product_id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->firstOrFail();

        $cart->quantity = $request->quantity;
        $cart->save();

        return redirect()->route('cart.index')->with('success', 'Jumlah produk diperbarui!');
    }

    /**
     * Menghapus produk dari keranjang
     */
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:carts,product_id'
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang!');
        }

        return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    
    /**
     * Checkout melalui WhatsApp
     */
    public function checkoutWa()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $message = "Halo, saya ingin melakukan pemesanan:\n\n";
        $total = 0;

        foreach ($cartItems as $item) {
            $productName = optional($item->product)->name ?? 'Produk tidak ditemukan';
            $quantity = $item->quantity;
            $price = optional($item->product)->price ?? 0;
            $subtotal = $price * $quantity;
            $total += $subtotal;

            $productLink = route('products.show', ['id' => optional($item->product)->id]);
            $productImage = asset('storage/' . optional($item->product)->image1);

            $message .= "- {$productName} x{$quantity} = Rp " . number_format($subtotal, 0, ',', '.') . "\n";
            $message .= "  Lihat produk: {$productLink}\n";
            $message .= "  Gambar: {$productImage}\n\n";
        }

        $message .= "\nTotal: Rp " . number_format($total, 0, ',', '.');
        $message .= "\n\nMohon konfirmasi pesanan saya. Terima kasih!";

        $encodedMessage = urlencode($message);
        $whatsappNumber = "6281219657322";

        return redirect("https://wa.me/{$whatsappNumber}?text={$encodedMessage}");
    }

    /**
     * Menampilkan keranjang di navbar
     */
    public function getCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        return response()->json([
            'cart_items' => $cartItems,
            'cart_count' => $cartItems->sum('quantity')
        ]);
    }
}
