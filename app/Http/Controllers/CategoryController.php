<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('pages.categories.category', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
        ]);

        $input = $request->all();

        Category::create($input);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori Berhasil Ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('pages.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'  => 'required',
        ]);

        $input = $request->all();
        $category->update($input);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori Berhasil Diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Product::where('category_id', $id)->first();

        if (!empty($category)) {
            return redirect()->route('categories.index')->with('failed', 'Kategori Gagal Dihapus. Pastikan Produk Tidak Menggunakan Kategori Tersebut');
        }

        Category::destroy($id);
        return redirect()->route('categories.index')->with('success', 'Kategori Berhasil Dihapus');
    }
}
