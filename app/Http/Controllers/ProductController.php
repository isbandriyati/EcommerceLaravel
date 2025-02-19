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


    public function userIndex(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();

        $query = Product::query()->with(['category', 'brand']); // Eager load

        // Filter Kategori (One-to-Many)
        if ($request->filled('categories')) {
            $selectedCategory = $request->categories;
            $query->where('category_id', $selectedCategory);
        }

        // Filter Brand
        if ($request->filled('brands')) {
            $selectedBrands = is_array($request->brands) ? $request->brands : [$request->brands];
            $query->whereIn('brand_id', $selectedBrands);
        }

        // Filter Harga
        if ($request->filled('price')) {
            $query->where('price', '<=', $request->price);
        }

        $products = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('HalamanHome.HalamanProduct.product_list', compact('products'))->render(),
                'pagination' => $products->links()->toHtml()
            ]);
        }

        return view('HalamanHome.HalamanProduct.index', compact('categories', 'products', 'brands'));
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

        DB::beginTransaction(); // Start transaction

        try {
            $product = new Product();
            $product->name = $validated['name'];
            $product->description = $validated['description'];
            $product->brand_id = $validated['brand_id'];
            $product->prosesor = json_encode($validated['prosesor']);
            $product->memory = json_encode($validated['memory_options']);
            $product->price = $validated['price'];
            $product->category_id = $validated['category_id'];
            $product->stock = $validated['stock'];

            if ($request->hasFile('images')) {
                $uploadedImages = $request->file('images');
                $imageFields = ['image1', 'image2', 'image3', 'image4'];

                foreach ($uploadedImages as $index => $image) {
                    if (isset($imageFields[$index])) {
                        $product->{$imageFields[$index]} = $image->store('images', 'public');
                    }
                }
            }

            $product->save();

            DB::commit(); // Commit transaction

            return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaction on error
            return back()->with('error', 'Gagal menambahkan produk. Silakan coba lagi. ' . $e->getMessage()); // Tampilkan pesan error
        }
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
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif|max:2048',
            'stock' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);
            $product->name = $validated['name'];
            $product->description = $validated['description'];
            $product->brand_id = $validated['brand_id'];
            $product->prosesor = json_encode($validated['prosesor']);
            $product->memory = json_encode($validated['memory_options']);
            $product->price = $validated['price'];
            $product->category_id = $validated['category_id'];
            $product->stock = $validated['stock'];

            if ($request->hasFile('images')) {
                $uploadedImages = $request->file('images');
                $imageFields = ['image1', 'image2', 'image3', 'image4'];

                foreach ($uploadedImages as $index => $image) {
                    if (isset($imageFields[$index])) {
                        if ($product->{$imageFields[$index]}) {
                            \Storage::disk('public')->delete($product->{$imageFields[$index]});
                        }
                        $product->{$imageFields[$index]} = $image->store('images', 'public');
                    }
                }
            }

            $product->save();

            DB::commit();
            return redirect()->route('product.index')->with('success', 'Produk berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengupdate produk. Silakan coba lagi. ' . $e->getMessage());
        }
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

   
    public function searchProduct(Request $request){

    $search = $request->search;
    $products = Product::where('name', 'LIKE', '%' .$search.'%');
    return view('home', compact('products'));
    }
    
    public function showCategory($id)
{
    $category = Category::findOrFail($id);
    $products = Product::where('category_id', $id)->with(['categories', 'brand'])->get();
    $categories = Category::all(); // Untuk filter di sidebar
    $brands = Brand::all();       // Untuk filter di sidebar

    return view('HalamanHome.category.product', compact('category', 'products', 'categories', 'brands'));
}

public function showBrand($id)
{
    $brand = Brand::findOrFail($id);
    $products = Product::where('brand_id', $id)->with(['categories', 'brand'])->get();
    $categories = Category::all(); // Untuk filter di sidebar
    $brands = Brand::all();       // Untuk filter di sidebar

    return view('HalamanHome.brand.product', compact('brand', 'products', 'categories', 'brands')); // View berbeda
}

}
