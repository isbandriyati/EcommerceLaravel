<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::all(); 

    return view('products.index', compact('categories', 'products'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('Admin.Products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'stock' => 'required|integer|min:0',
        ]);
    
        // Menyimpan produk baru
        $product = new Product();
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->category_id = $validated['category_id'];
        $product->stock = $validated['stock'];
        
    
        // Menyimpan gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }
    
        $product->save();
    
        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id); // Mencari produk berdasarkan ID
        $categories = Category::all(); // Mengambil semua kategori
        return view('Admin.Products.edit', compact('product', 'categories')); // Mengirimkan data produk dan kategori ke tampilan
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->category_id = $validated['category_id'];
        $product->stock = $validated['stock'];

         // Menyimpan gambar baru jika ada
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('image' , 'public');
        $product->image = $imagePath;
    }

    $product->save();

    return redirect()->route('product.index')->with('success', 'Produk berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id); // Cari produk berdasarkan ID
        $product->delete(); // Hapus produk
        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus');
    }

    public function showCategory($id)
    {
    $category = Category::findOrFail($id);
    $products = Product::where('category_id', $id)->get();
    $categories = Category::all();

    return view('HalamanHome.category.product', compact('category', 'products', 'categories'));
    }
    
}
