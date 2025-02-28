<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Resources\BrandResource;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 5);

        return Inertia::render('Cms/Brand/Index', [
            'brandData' => Brand::query()
                ->paginate($perPage)
                ->appends($request->query()),
        ]);
    }
}
