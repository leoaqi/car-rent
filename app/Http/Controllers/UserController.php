<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function store(Request $request) {
        dd($request->all());
    }

    public function index(){
        return Inertia::render('Auth/AuthView');
    }

    public function show($id)
    {
        dd('SHOW ' .  $id);
    }
}
