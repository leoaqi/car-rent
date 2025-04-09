<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Resources\BrandResource;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 10);

        return Inertia::render('Cms/Brand/Index', [
            'brandData' => Brand::query()
                ->paginate($perPage)
                ->appends($request->query()),
        ]);
    }

    public function add(){
        return Inertia::render('Cms/Brand/AddBrand');
    }

    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();

            return redirect()->back()
                ->with('message', 'Brand delete successfully')
                ->with('type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('message', 'Failed to delete brand')
                ->with('type', 'error');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name'
        ]);

        try {
            Brand::create([
                'name' => $request->name
            ]);    

            return redirect()->route('brand')
                ->with('message', 'Brand created successfully')
                ->with('type', 'success');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('message', 'Failed to create brand')
                ->with('type', 'error');
        }
    }

    public function edit($id){
        $brand = Brand::findOrFail($id);
        return Inertia::render('Cms/Brand/AddBrand', [
            'brand' => $brand
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' =>'required|string|max:255|unique:brands,name,'.$id
        ]);
        try {
            $brand = Brand::findOrFail($id);
            $brand->update([
                'name' => $request->name
            ]);
            return redirect('/brand')
                ->with('message', 'Brand updated successfully')
                ->with('type','success');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('message', 'Failed to update brand')
                ->with('type', 'error');
        }
    }
}
