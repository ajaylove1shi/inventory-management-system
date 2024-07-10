<?php

namespace App\Http\Controllers\Dashboard\Category;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index(Request $request)
    {

        $categories = Category::paginate(25);
        $parents    = Category::whereNull('parent_id')->pluck('name', 'id');
        return view('dashboard.pages.categories.index', compact('categories', 'parents'));
    }

    public function store(Request $request)
    {
        //validate category...
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        //create category...
        $category       = new Category();
        $category->name = $request->input('name');
        $category->slug = Str::slug($request->input('name'), '-');
        if (!empty($request->input('parent'))) {
            $category->parent_id = $request->input('parent');
        }
        //save category...
        if ($category->save()) {
            //redirect to all category...
            session()->flash('status', "success");
            session()->flash('text', "Category has been added successfully.");
            return redirect()->route('categories.index');
        }
    }

    public function edit($id)
    {
        $category   = Category::findOrFail($id);
        $categories = Category::paginate(25);
        $parents    = Category::whereNull('parent_id')->pluck('name', 'id');
        return view('dashboard.pages.categories.index', compact('category', 'categories', 'parents'));
    }

    public function update(Request $request, $id)
    {
        //validate category...
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        //update category...
        $category       = Category::findOrFail($id);
        $category->name = $request->input('name');
        $category->slug = Str::slug($request->input('name'), '-');
        if (!empty($request->input('parent'))) {
            $category->parent_id = $request->input('parent');
        }

        //save category...
        if ($category->save()) {
            //redirect to all category...
            session()->flash('status', "success");
            session()->flash('text', "Category has been updated successfully.");
            return redirect()->route('categories.index');
        }

    }

    public function destroy($id)
    {
        if (request()->ajax()) {
            $category = Category::findOrFail($id);
            if ($category->delete()) {
                session()->flash('status', "success");
                session()->flash('text', "Category has been deleted successfully.");
                return response()->json(['status' => 'success', 'message' => 'Category has been deleted successfully.']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Http request']);
    }

}
