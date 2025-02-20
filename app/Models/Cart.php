<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;

class Cart extends Model
{
    protected $table = 'carts' ;
    
    protected $fillable = [
        'quantity',
        'product_id',
        'user_id',
    ];

    public function index()
    {
        $cart = Cart::with('product')->where('user_id', auth()->id())->first(); // Ambil cart user
        $cartItems = $cart ? $cart->product : collect(); // Pastikan $cartItems selalu berupa Collection

        return view('cart.index', compact('cartItems')); // Atau view lain yang sesuai
    }


    public function add(Request $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->quantity;

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Cek apakah produk sudah ada di cart
        $existingProduct = $cart->product->find($product_id);

        if ($existingProduct) {
            // Update quantity jika produk sudah ada di cart
            $cart->product()->updateExistingPivot($product_id, ['quantity' => $existingProduct->pivot->quantity + $quantity]);
        } else {
            // Tambahkan produk baru ke cart
            $cart->product()->attach($product_id, ['quantity' => $quantity]);
        }


        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }


    public function remove(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->product()->detach($request->product_id); // Detach untuk menghapus relasi di pivot table
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);

    }
    
    public function user()

    {
        return $this->belongsTo(User::class);
    
    }
}