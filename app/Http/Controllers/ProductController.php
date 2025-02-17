<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $products = Product::all(); 

    return view('Admin.Products.index', compact('categories', 'products','brands'));
    }


    public function userIndex()
    {
    $categories = Category::all();
    $products = Product::paginate(15); 
    $brands = Brand::all();

    return view('HalamanHome.HalamanProduct.index', compact('categories', 'products','brands'));

     $query = Product::query();

    if ($request->has('categories')) {
        $query->whereIn('category_id', $request->categories);
    }

    if ($request->has('brands')) {
        $query->whereIn('brand_id', $request->brands);
    }

    $products = $query->get();

    if ($request->ajax()) {
        $html = view('partials.product_list', compact('products'))->render();
        return response()->json(['html' => $html]);
    }

    return view('products.index', compact('products'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('Admin.Products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'prosesor' => 'required|array',
            'prosesor.*' => 'string|max:255',
            'memory_options' => 'required|array',
            'memory_options.*' => 'string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image1' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif',
            'image2' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif',
            'image3' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif',
            'image4' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif',
            'stock' => 'required|integer|min:0',
        ]);
    
        // Menyimpan produk baru
        $product = new Product();
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->brand_id= $validated['brand_id'];
        $product->prosesor = json_encode($validated['prosesor']); // Langsung array
        $product->memory = json_encode($validated['memory_options']); 
        $product->price = $validated['price'];
        $product->category_id = $validated['category_id'];
        $product->stock = $validated['stock'];
    
        
    
        // Menyimpan gambar jika ada
        if ($request->hasFile('images')) {
            $uploadedImages = $request->file('images');
            $imageFields = ['image1', 'image2', 'image3', 'image4']; // Kolom di database
        
            foreach ($uploadedImages as $index => $image) {
                if (isset($imageFields[$index])) {
                    $product->{$imageFields[$index]} = $image->store('images', 'public');
                }
            }
        }
    
        $product->save();
    
        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan');
    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('brand')->findOrFail($id);
        $categories = Category::all();
        

        return view('HalamanHome.HalamanProduct.show', compact('product','categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id); // Mencari produk berdasarkan ID
        $categories = Category::all(); // Mengambil semua kategori
        $brands = Brand::all();

        $product->prosesor = json_decode($product->prosesor,'[]', true);
        $product->memory = json_decode($product->memory,'[]', true);

        return view('Admin.Products.edit', compact('product', 'categories', 'brands'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric',
            'prosesor' => 'required|array',
            'prosesor.*' => 'string|max:255',
            'memory_options' => 'required|array',
            'memory_options.*' => 'string|max:255',
            'category_id' => 'required|exists:categories,id',
            'images' => 'nullable|array', // Pastikan images adalah array
            'images.*' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif|max:2048', // Validasi setiap file
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->brand_id= $validated['brand_id'];
        $product->prosesor = json_encode($validated['prosesor']); // Langsung array
        $product->memory = json_encode($validated['memory_options']); 
        $product->price = $validated['price'];
        $product->category_id = $validated['category_id'];
        $product->stock = $validated['stock'];

         // Menyimpan gambar baru jika ada
         if ($request->hasFile('images')) {
            $uploadedImages = $request->file('images');
            $imageFields = ['image1', 'image2', 'image3', 'image4'];
        
            foreach ($uploadedImages as $index => $image) {
                if (isset($imageFields[$index])) {
                    // Hapus gambar lama jika ada
                    if ($product->{$imageFields[$index]}) {
                        \Storage::disk('public')->delete($product->{$imageFields[$index]});
                    }
        
                    // Simpan gambar baru
                    $product->{$imageFields[$index]} = $image->store('images', 'public');
                }
            }
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
    $brands = Brand::all();

    return view('HalamanHome.category.product', compact('category', 'products', 'categories', 'brands'));
    }


    public function searchProduct(Request $request){

    $search = $request->search;
    $products = Product::where('name', 'LIKE', '%' .$search.'%');
    return view('home', compact('products'));
    }
    
}
