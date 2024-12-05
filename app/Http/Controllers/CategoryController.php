<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /*** Fungsi untuk menyimpan category dari form blade ***/
    public function index(Request $request)
    {
        $categories = Category::paginate(5);
        return view('pages.category.view', compact('categories'));
    }

    public function create()
    {
        return view('pages.category.add');
    }

    public function store(Request $request)
    {
        $input = $request->input();
        $category = new Category();
        $category->category =  $request->category;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'New Category added successfully.');
    }

    /*** Fungsi untuk menghapus list wallet dari form blade ***/
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect()->route('categories.index');
    }

    /*** Fungsi untuk mengedit list category dari form blade ***/
    public function edit(Request $request, $id)
    {
        $category = Category::find($id);
        return view('pages.category.edit', compact('category'));
    }

    /*** Fungsi untuk mengupdate category dari form blade ***/
    public function update(Request $request, $id)
    {
        $input = $request->input();

        $category = Category::find($id);
        $category->category =  $request->category;
        $category->save();

        return redirect()->route('categories.index');
        // $request->status == 0 && $category->status != 0
    }
}