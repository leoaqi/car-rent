<?php

namespace App\Http\Controllers\FronSite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TourPackage extends Controller
{
    public function index(){
        return Inertia::render('FrontSite/TourPackages');
    }
}
