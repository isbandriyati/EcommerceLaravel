<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Cart;



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
    $cartItems = Cart::all();


    $query = Product::query()->with(['Category', 'Brand']);

    // Filter Kategori
    if ($request->has('categories')) { // Gunakan has() untuk memeriksa keberadaan parameter
        $selectedCategories = $request->categories;
        if (is_array($selectedCategories)) { // Pastikan ini array, walaupun seharusnya sudah karena name="categories[]"
            $query->whereIn('category_id', $selectedCategories);
        } else {
            $query->where('category_id', $selectedCategories); // Handle jika hanya satu kategori dipilih
        }

    }

    // Filter Brand (Peningkatan)
    if ($request->has('brands')) {
        $selectedBrands = $request->brands;
         if (is_array($selectedBrands)) { // Pastikan ini array, walaupun seharusnya sudah karena name="brands[]"
            $query->whereIn('brand_id', $selectedBrands);
        } else {
            $query->where('brand_id', $selectedBrands); // Handle jika hanya satu brand dipilih
        }
    }

    // Filter Harga (Peningkatan)
    if ($request->has('price')) {
        $price = $request->price;
        if (is_numeric($price)) { // Pastikan harga adalah angka
            $query->where('price', '<=', $price);
        }
    }

    $products = $query->paginate(15);

    if ($request->ajax()) {
        return response()->json([
            'html' => view('HalamanHome.HalamanProduct.product_list', compact('categories','products'))->render(),
            'pagination' => $products->links()->toHtml()
        ]);
    }

    return view('HalamanHome.HalamanProduct.index', compact('categories', 'products', 'brands','cartItems'));
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
        $cartItems = Cart::all();
    
        $similarProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(6)
            ->get();
    
        return view('HalamanHome.HalamanProduct.show', compact('product', 'categories', 'similarProducts','cartItems')); // Nama variabel yang benar: $similarProducts
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
            return redirect()->route('Admin.product.index')->with('success', 'Produk berhasil diupdate');

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
        return redirect()->route('Admin.product.index')->with('success', 'Produk berhasil dihapus');
    }

   
    public function searchProduct(Request $request){

    $search = $request->search;
    $products = Product::where('name', 'LIKE', '%' .$search.'%');
    return view('home', compact('products'));
    }
    
    public function showCategory($id)
{
    $category = Category::findOrFail($id);
    $products = Product::where('category_id', $id)->with(['category', 'brand'])->get();
    $categories = Category::all(); // Untuk filter di sidebar
    $brands = Brand::all();       // Untuk filter di sidebar

    return view('HalamanHome.HalamanProduct.product_list', compact('category', 'products','brands'));
}

public function showBrand($id)
{
    $brand = Brand::findOrFail($id);
    $products = Product::where('brand_id', $id)->with(['categories', 'brand'])->get();
    $categories = Category::all(); // Untuk filter di sidebar
    $brands = Brand::all();       // Untuk filter di sidebar

    return view('HalamanHome.brand.product', compact('brand', 'products', 'categories', 'brands')); // View berbeda
}

public function ProductCategory($id) {
    $category = Category::findOrFail($id);
    $categories = Category::all();
    $products = Product::where('category_id', $id)->with(['category', 'brand'])->get();
    $brands = Brand::all();
    $cartItems = Cart::all();


    return view('HalamanHome.Category.index', compact('category','categories','products','brands','cartItems'));

}



public function filterProducts(Request $request)
{
    $categories = Category::all();
    $brands = Brand::all();
    $cartItems = Cart::all();
    $products = Product::query();

    // Filter berdasarkan kategori
    if ($request->has('categories')) {
        $products->whereIn('category_id', $request->input('categories'));
    }

    // Filter berdasarkan merek
    if ($request->has('brands')) {
        $products->whereIn('brand_id', $request->input('brands'));
    }

    // Filter berdasarkan harga
    if ($request->has('price')) {
        $products->where('price', '<=', $request->input('price'));
    }

    $products = $products->paginate(10); // Atau sesuai dengan jumlah produk per halaman

    return view('HalamanHome.HalamanProduct.index', compact('products', 'categories', 'brands','cartItems')); // Sesuaikan view name
}


}
