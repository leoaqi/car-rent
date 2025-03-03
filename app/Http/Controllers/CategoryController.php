<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 5);

        $data = Category::query()
        ->paginate($perPage)
        ->appends($request->query());

        Log::info($data);

        return Inertia::render('Cms/Category/Index', [
            'data' => Category::query()
                ->paginate($perPage)
                ->appends($request->query()),
        ]);
    }

    public function delete($id){
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->back()->with('success', 'Category deleted successfully.');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Category not found.');
        }
    }

    public function add(){
        return Inertia::render('Cms/Category/AddCategory');
    }

    public function store(Request $request){
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
            Category::create([
                'name' => $request->name,
            ]);
            return redirect()->route('category')->with('success', 'Category created successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Category not created.');
        }
    }

    public function edit($id){
        $category = Category::findOrFail($id);
        return Inertia::render('Cms/Category/AddCategory', [
            'category' => $category
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' =>'required|string|max:255|unique:brands,name,'.$id
        ]);
        try {
            $category = Category::findOrFail($id);
            $category->update([
                'name' => $request->name
            ]);
            return redirect('/category')
                ->with('message', 'Category updated successfully')
                ->with('type','success');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('message', 'Failed to update category')
                ->with('type', 'error');
        }
    }
}
