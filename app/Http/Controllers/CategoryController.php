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
}
