<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('Admin.KategoriProduct.index', compact('categories'));
    }

    public function create()
    {
        return view('Admin.KategoriProduct.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',  // Validasi gambar

        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Category::create([
            'name' => $request->name,
            'image' => isset($imagePath) ? $imagePath : null,  // Simpan path gambar di DB
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('Admin.KategoriProduct.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);
    
        // Jika ada gambar baru, simpan dan update gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
    
            // Menyimpan gambar baru
            $imagePath = $request->file('image')->store('images', 'public');
            $category->image = $imagePath;  // Update gambar di database
        }
    
        // Update nama kategori
        $category->update([
            'name' => $request->name,
        ]);
    
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
