<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->get();
        return view('HalamanHome.Cart.index', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity ?? 1;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1,
            ];
        }

        session()->put('cart', $cart);
        
        $carHtml = '';
        $cartHtml = "";
foreach ($cart as $item) {
    $cartHtml .= "<li>{$item['name']} x{$item['quantity']}</li>";
}
        return response()->json([
            'count' => count($cart),
            'cart_html' => $cartHtml
        ]);
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui!');
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang!');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Keranjang dikosongkan!');
    }
}


