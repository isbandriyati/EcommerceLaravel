<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('HalamanHome.Cart.index', compact('cartItems'));
    }

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

        // Mengembalikan respons JSON jika request berasal dari AJAX, jika tidak redirect.
        if ($request->wantsJson()) {
            $cartItems = Cart::where('user_id', $user->id)->with('product')->get(); // Ambil data cart setelah update
            return response()->json([
                'message' => 'Item berhasil ditambahkan ke keranjang!',
                'cartCount' => $cartItems->sum('quantity'),
                'cartItems' => $cartItems // Sertakan cartItems jika diperlukan di frontend
            ]);
        } else {
            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        }
    }


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

    public function clearCart()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }

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
            $message .= "  Lihat produk: {$productLink}\n";
            $message .= "  Gambar: {$productImage}\n\n";
        }

        $message .= "\nTotal: Rp " . number_format($total, 0, ',', '.');
        $message .= "\n\nMohon konfirmasi pesanan saya. Terima kasih!";

        $encodedMessage = urlencode($message);
        $whatsappNumber = "6281219657322"; // Ganti dengan nomor WhatsApp Anda

        return redirect("https://wa.me/{$whatsappNumber}?text={$encodedMessage}");
    }

    public function getCartItems()
    {

       $cartItems = Cart::all();

        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        return response()->json([
            'cart_items' => $cartItems,
            'cart_count' => $cartItems->sum('quantity'),
            'total_price' => $totalPrice
        ]);
    }
}