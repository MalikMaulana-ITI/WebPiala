<?php

namespace App\Http\Controllers;

use App\Models\Trophy;
use App\Models\TrophyMaterial;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class CatalogController extends Controller
{
    public function index()
    {
        Session::flush();

        // $trophies = Trophy::with('trophyMaterial')->get();
        // $allMaterials = TrophyMaterial::all();
        // return view("pages.catalog", compact('trophies', 'allMaterials'));

        return view("pages.catalog");
    }
}
