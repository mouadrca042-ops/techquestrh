<?php

namespace App\Http\Controllers;

use App\Models\Parcours;
use Illuminate\Http\Request;

class ParcoursController extends Controller
{
    public function index()
    {
        $parcours = Parcours::all();
        return view('dashboard', compact('parcours'));
    }
}